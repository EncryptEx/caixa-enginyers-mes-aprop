import pandas as pd
import requests

def get_driving_distance(lat1, lon1, lat2, lon2):
    url = f"https://router.project-osrm.org/route/v1/driving/{lon1},{lat1};{lon2},{lat2}?steps=false&geometries=geojson"
    response = requests.get(url)
    if response.status_code == 200 and response.json()['code'] == 'Ok':
        route = response.json()['routes'][0]
        distance = route['distance']  # distance in meters
        duration = route['duration']  # duration in seconds
        return duration / 3600  # return duration in hours
    else:
        raise ValueError("Error in fetching route information")

def read_city_data_with_bloc(csv_file):
    df = pd.read_csv(csv_file)
    return df

def calculate_distances_by_bloc(csv_file, output_csv):
    # Read city data with Bloc information
    df = read_city_data_with_bloc(csv_file)
    
    # Group by 'BLOC' and calculate distances
    results = []
    for bloc, group in df.groupby('BLOC'):
        cities = group.to_dict('records')
        for i in range(len(cities)):
            for j in range(i + 1, len(cities)):
                city1 = cities[i]   
                city2 = cities[j]
                print(city1)
                print(city2)
                try:
                    duration = get_driving_distance(city1['latitude'], city1['longitude'], city2['latitude'], city2['longitude'])
                    #duration = get_driving_distance(city1['latitude'], city1['longitude'], 41.3762309, 1.1620703)
                    if duration > 2.0:
                        print(f"ERROR-----------------------------------------{duration} {city1['municipi']} {city2['municipi']}" )
                    results.append({
                        'BLOC': bloc,
                        'City1': city1['municipi'],
                        'City2': city2['municipi'],
                        #'City2': "Montblanc",
                        'Duration (hours)': duration
                    })
                except ValueError as e:
                    pass
                    #print(f"Error calculating distance between {city1['municipi']} and {city2['municipi']}: {e}")
            
    # Convert results to DataFrame and save to CSV
    df_results = pd.DataFrame(results)
    df_results.to_csv(output_csv, index=False)

csv_file = 'coordinates_lot2.csv' 
output_csv = 'distances_lot2.csv'
calculate_distances_by_bloc(csv_file, output_csv)
