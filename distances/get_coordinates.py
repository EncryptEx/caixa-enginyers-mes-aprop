import pandas as pd
import requests
from fake_useragent import UserAgent

# Function to get coordinates, enhanced with user agent
def get_coordinates(city_name, headers):
    parsed_city_name = city_name.replace(" ", "%20")
    parsed_city_name = parsed_city_name.replace("'", "%20")
    url = f"https://nominatim.openstreetmap.org/search?q={parsed_city_name},Catalunya,Spain&format=json&limit=1"
    print(url)
    response = requests.get(url, headers=headers)
    print(response)
    if response.status_code == 200 and response.json():
        data = response.json()[0]
        return float(data['lat']), float(data['lon'])
    else:
        raise ValueError(f"Unable to get coordinates for {city_name}")
    

# Function to extract data and store coordinates
def extract_and_store_coordinates(xlsx_file, output_csv, slt):
    # Initialize UserAgent
    ua = UserAgent()

    # Read the XLSX file
    df = pd.read_excel(xlsx_file, sheet_name=slt)
    
    # Check if 'Municipi' column exists in the DataFrame
    if 'Municipi' not in df.columns:
        raise ValueError("The input XLSX file does not contain a 'Municipi' column.")
    
    # Initialize list to store data
    data = []
    
    # Iterate over each row to get 'Municipi' and fetch coordinates
    for index, row in df.iterrows():
        municipi = row['Municipi']
        bloc = row['BLOC']
        headers = {'User-Agent': ua.random}
        coordinates = get_coordinates(municipi, headers)
        data.append({'municipi': municipi, 'latitude': coordinates[0], 'longitude': coordinates[1], 'BLOC': bloc})
        print(row['Municipi'])
    
    # Convert the data to a DataFrame and save as CSV
    output_df = pd.DataFrame(data)
    output_df.to_csv(output_csv, index=False)

# Example usage
xlsx_file = '../data/Dades_Municipis.xlsx'
output_csv = 'coordinates_lot2.csv'
extract_and_store_coordinates(xlsx_file, output_csv, 1)
