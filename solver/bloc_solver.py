import random
import pandas as pd
from copy import deepcopy
import math
from json_translator import compute_route

MAX_HORES = 8
PARAM_PONDERADOR_HORES = 1


def print_week(week):
    for i, day in enumerate(week):
        print(f"Day {i + 1}: {', '.join(day)}")

#Simulated annealing


def get_random_successor(week):
    new_week = deepcopy(week)
    
    if random.random() < 0.5:
        # Perform a move
        while True:
            day_from = random.randint(0, 4)
            day_to = random.randint(0, 4)
            
            if day_from != day_to and new_week[day_from]:  # Ensure different days and day_from is not empty
                city = random.choice(new_week[day_from])
                new_week[day_from].remove(city)
                new_week[day_to].append(city)
                break
    else:
        # Perform a swap
        while True:
            day1 = random.randint(0, 4)
            day2 = random.randint(0, 4)
            
            if day1 != day2 and new_week[day1] and new_week[day2]:  # Ensure different days and both are not empty
                city1 = random.choice(new_week[day1])
                city2 = random.choice(new_week[day2])
                new_week[day1].remove(city1)
                new_week[day2].remove(city2)
                new_week[day1].append(city2)
                new_week[day2].append(city1)
                break
    
    return new_week


#==========================================================
def get_successors(week):
    all_possible_weeks = []
    
    for day_from in range(5):
        if week[day_from]:  # Ensure the day_from is not empty
            for city in week[day_from]:
                for day_to in range(5):
                    if day_to != day_from:  # Ensure the city is moved to a different day
                        new_week = deepcopy(week)
                        new_week[day_from].remove(city)
                        new_week[day_to].append(city)
                        all_possible_weeks.append(new_week)
                        
    return all_possible_weeks

#heuristic================================================

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

def get_ponderador(city, min_times, param):
    result = min_times[min_times['municipi'] == city][param]
    return result.iloc[0] if not result.empty else None


def assignacio_optima_ciutats(day, distancies_entre_ciutats_lot, min_times):
    new_order = []
    total_time = 0
    total_time_activity = 0

    if len(day) > 0:
        current_city = day[0]
        new_order.append(current_city)
        
        while len(new_order) < len(day):
            min_distance = float('inf')
            next_city = None

            for city in day:
                if city not in new_order:
                    distance = get_distance(current_city, city, distancies_entre_ciutats_lot)
                    #distance -= PARAM_PONDERADOR_HORES * (get_ponderador(city, min_times, "MATI") if total_time < 4.5 else (get_ponderador(city, min_times, "MIGDIA") if total_time < 7.5 else get_ponderador(city, min_times, "TARDA") ))
                    if distance < min_distance:
                        min_distance = distance
                        next_city = city

            if next_city:
                new_order.append(next_city)
                total_time += min_distance
                total_time_activity += min_distance
                total_time_activity += get_min_time(next_city, min_times)
                current_city = next_city


    print(f"total_time_driving: {total_time}")
    print(f"total_time_activity: {total_time_activity}")
    return new_order, total_time, total_time_activity


def heuristic(week, distancies_entre_ciutats_lot, min_times, origen_city):
    total_travel_time = 0
    heuristi = 0
    for dayog in week:
        day = deepcopy(dayog)
        #day.append(origen_city)
        day = [origen_city] + day
        optimal_distribution, optimal_time_traveling, total_time_heuristic = assignacio_optima_ciutats(day, distancies_entre_ciutats_lot, min_times)
        temps_treballant = sum(list(get_min_time(city, min_times) for city in optimal_distribution))
        
        total_day_time = temps_treballant + optimal_time_traveling

        if total_day_time > MAX_HORES:
            heuristi +=  -1000*(temps_treballant - MAX_HORES ) + total_time_heuristic
        else:
            heuristi += total_time_heuristic*100 - optimal_time_traveling*100
            #heuristi += - optimal_time

    return heuristi

#heuristic_minimize_travel_time
def heuristic_minimize_travel_time(week, distancies_entre_ciutats_lot, min_times, origen_city):
    total_travel_time = 0
    heuristic = 0
    for day in week:
        day_cities = deepcopy(day)
        day_cities.append(origen_city)
        
        optimal_distribution, optimal_time, _ = assignacio_optima_ciutats(day_cities, distancies_entre_ciutats_lot, min_times)
        working_time = sum(get_min_time(city, min_times) for city in optimal_distribution)
        
        total_day_time = working_time + optimal_time
        if total_day_time > MAX_HORES:
            total_travel_time += -100 * (total_day_time - MAX_HORES) 
        else:
            total_travel_time += -optimal_time
    
    return total_travel_time  



#hill climbing

def hill_climbing(week, max_iterations, distancies_entre_ciutats_lot, min_times, origen_city):
    current_week = week
    current_productivity = heuristic(current_week,distancies_entre_ciutats_lot, min_times, origen_city)
    
    for _ in range(max_iterations):
        successors = get_successors(current_week)
        best_successor = None
        best_productivity = current_productivity
        
        for successor in successors:
            new_productivity = heuristic(successor, distancies_entre_ciutats_lot, min_times,origen_city)
            if new_productivity > best_productivity:
                best_successor = successor
                best_productivity = new_productivity
                
        if best_successor is None:
            # No improvement found
            break
        
        current_week = best_successor
        current_productivity = best_productivity

        print("-------------New Better State---------------")
        print_week(current_week)
        print("Productivity:", current_productivity)
        print("-----------------------------------------")

    return current_week
#SA
def simulated_annealing(week, max_iterations, distancies_entre_ciutats_lot, min_times, origen_city, initial_temp, cooling_rate):
    current_week = week
    current_productivity = heuristic(current_week, distancies_entre_ciutats_lot, min_times, origen_city)
    temperature = initial_temp
    best = 0
    best_week = week
    for iteration in range(max_iterations):
        
        next_week = get_random_successor(current_week)
        next_productivity = heuristic(next_week, distancies_entre_ciutats_lot, min_times, origen_city)
        #print(next_productivity)
        if best < next_productivity:
            best_week = next_week
        delta = next_productivity - current_productivity
        if delta > 0 or random.uniform(0, 1) < math.exp(delta / temperature):
            current_week = next_week
            current_productivity = next_productivity

            print("-------------New State---------------")
            print_week(current_week)
            print("Productivity:", current_productivity)
            print("Temperature:", temperature)
            print("-------------------------------------")
        
        temperature *= cooling_rate
        if temperature < 1e-10:  # Small threshold to avoid division by zero in exp calculation
            break
    if  heuristic(next_week, distancies_entre_ciutats_lot, min_times, origen_city) < best:
        return best_week            
    return current_week


def solve_bloc(bloc_id, lot_id, data):
    lots = {}
    lots[2] = 1
    lots[4] = 2
    lots[5] = 3
    df_lot = pd.read_excel('../data/Dades_Municipis.xlsx', sheet_name=lots.get(lot_id))  # obrir lot 2
    distancies_entre_ciutats_lot = pd.read_csv(f'../data/distances_lot{lot_id}.csv')
    min_times = pd.read_csv(f'../data/min_times.csv')
    origin_cities = pd.read_csv(f'../data/origin_cities.csv')
    origen_city = origin_cities[origin_cities["lot"] == lot_id].values[0]
    origen_city = origen_city[0]
    print("Origen city: " + origen_city)
    ciutats_bloc = df_lot.loc[df_lot['BLOC'] == bloc_id]

    print(f"\nBloc {bloc_id}\n\n")

    week = [[] for _ in range(5)]
    cities = ciutats_bloc['Municipi'].to_list()

    #assignacio inicial random
    for city in cities:
        day = random.randint(0, 4)
        week[day].append(city)

    print("-------------Estat inicial---------------")
    print_week(week)
    print("-----------------------------------------")  


    #best_week = hill_climbing(week, 1000, distancies_entre_ciutats_lot, min_times, origen_city)
    max_iterations = 100
    initial_temp = 100
    cooling_rate = 0.95

    best_week = simulated_annealing(week, max_iterations, distancies_entre_ciutats_lot, min_times, origen_city, initial_temp, cooling_rate)

    print("-------------Best State Found---------------")
    print_week(best_week)
    print("--------------------------------------------")

    final_route = []
    for _, dayc in enumerate(best_week):
        if dayc:
            day = deepcopy(dayc)
            day = [origen_city] + day
            optimal_distribution, optimal_time, t = assignacio_optima_ciutats(day, distancies_entre_ciutats_lot, min_times)
            temps_treballant = sum(list(get_min_time(city, min_times) for city in optimal_distribution))
            print(f"total_time_working {t}")
            #if temps_treballant + optimal_time > MAX_HORES:
            if t > MAX_HORES:
                print("-------------FALSE---------------")
            else:
                print("-------------WORKS---------------")
            route = compute_route(optimal_distribution + [origen_city], data, min_times, distancies_entre_ciutats_lot)
            final_route.extend(route)
    return final_route
