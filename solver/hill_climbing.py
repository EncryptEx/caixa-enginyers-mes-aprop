import random
import pandas as pd

# Read data:

file_path = '../data/Dades_Municipis.xlsx'

df = pd.read_excel(file_path, sheet_name=1)  # obrir lot 2

#print(df[1:10])

# ====================== bloc i ======================
for i in range(1,4):
    bloc = df.loc[df['BLOC'] == i]

    print(f"\n\nBloc {i}\n\n")
    
    # Hill Climbing:

    # State

    week = [[] for _ in range(5)]  # inside each day of the week       store cities in list

    #print(week)

    # week[0].append("Monday")


    cities = bloc['Municipi'].to_list()

    # dictionary   city: duration


    #print(cities)
    def print_week(week):
        # Print the best assignment and productivity
        for i, day in enumerate(week):
            print(f"Day {i + 1}: {day}")



    # Assign cities randomly to start
    for city in cities:
        day = random.randint(0, 4)
        week[day].append(city)

    print("-------------Estat inicial---------------")
    print_week(week)
    print("-----------------------------------------")


    # operator
    def move_city(week):
        # Randomly move a city from one day to another
        new_week = [day[:] for day in week]
        day_from = random.randint(0, 4)

        while not new_week[day_from]:  # Ensure the day_from is not empty
            day_from = random.randint(0, 4)
        city = random.choice(new_week[day_from])
        new_week[day_from].remove(city)
        day_to = random.randint(0, 4)
        new_week[day_to].append(city)
        return new_week


    def hill_climbing(week, max_iterations=1000):
        current_week = week
        current_productivity = random.randint(-100, 100)  #h(current_week)
        
        for _ in range(max_iterations):
            new_week = move_city(current_week)
            new_productivity = random.randint(-100, 100)
            
            if new_productivity > current_productivity:  # check if the new week is better than our best stored
                current_week = new_week
                current_productivity = new_productivity

                print("-------------New Better State---------------")
                print_week(current_week)
                print("-----------------------------------------")

        return current_week



    print("Inici HC")
    # Run hill climbing algorithm
    best_week = hill_climbing(week)

    print("-------------Best State Found---------------")
    print_week(best_week)
    print("--------------------------------------------")




