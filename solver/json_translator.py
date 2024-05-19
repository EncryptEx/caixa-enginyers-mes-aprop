import json
from datetime import datetime, timedelta

def get_distance(city1, city2, distancies_entre_ciutats_lot):
    mask = (distancies_entre_ciutats_lot['City1'] == city1) & (distancies_entre_ciutats_lot['City2'] == city2)
    result = distancies_entre_ciutats_lot[mask]
    if not result.empty:
        return result['Duration (hours)'].values[0]
    else:
        mask = (distancies_entre_ciutats_lot['City2'] == city1) & (distancies_entre_ciutats_lot['City1'] == city2)
        result = distancies_entre_ciutats_lot[mask]
        if not result.empty:
            return result['Duration (hours)'].values[0]
        print(f"ERROR:   c1->{city2} c2->{city1}")
        return None
    
def get_min_time(city, min_times):

    result = min_times[min_times['municipi'] == city]['Estancia Minima']
    return result.iloc[0] if not result.empty else None

def compute_route(cities, start_date, min_times, distancies_entre_ciutats_lot):
    start_time = datetime.strptime(start_date, '%Y-%m-%dT%H:%M:%S%z')
    route = []

    for i in range(len(cities) - 1):
        lloc_sortida = cities[i]
        desti = cities[i + 1]

        # Departure
        route.append({
            "tipus": "sortida",
            "hora": start_time.isoformat(),
            "temps_trajecte": str(int(60*get_distance(lloc_sortida, desti, distancies_entre_ciutats_lot))),
            "lloc_sortida": lloc_sortida,
            "desti": desti
        })

        # Calculate arrival time
        travel_time = timedelta(minutes=get_distance(lloc_sortida, desti, distancies_entre_ciutats_lot))
        start_time += travel_time

        # Arrival
        route.append({
            "tipus": "arribada",
            "hora": start_time.isoformat(),
            "lloc_arribada": desti,
            "duracio_estada": str(get_min_time(desti, min_times))
        })

        # Calculate next departure time
        stay_duration = timedelta(minutes=get_min_time(desti, min_times))
        start_time += stay_duration

    return route

'''# Example usage
cities = ["ribes de freser", "berga", "barcelona"]
start_date = "2024-05-18T08:00:00+02:00"
route_json = compute_route(cities, start_date)
print(route_json)
'''