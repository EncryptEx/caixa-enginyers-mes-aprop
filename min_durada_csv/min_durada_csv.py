import pandas as pd
import requests
from fake_useragent import UserAgent


# Function to extract data and store coordinates
def extract_min_time(xlsx_file, output_csv):

    df = pd.read_excel(xlsx_file, sheet_name=1)
    
    if 'Municipi' not in df.columns:
        raise ValueError("The input XLSX file does not contain a 'Municipi' column.")
    

    data = []
    

    for _, row in df.iterrows():
        municipi = row['Municipi']
        t = int(row['Estancia Minima'].strip().split()[0])
        duracio_hores = (t if "HORA" in row['Estancia Minima'] else t/60)
        data.append({'municipi': municipi, "Estancia Minima":duracio_hores })
        print(row['Municipi'])
    
    df = pd.read_excel(xlsx_file, sheet_name=2)
    
    for _, row in df.iterrows():
        municipi = row['Municipi']
        t = int(row['Estancia Minima'].strip().split()[0])
        duracio_hores = (t if "HORA" in row['Estancia Minima'] else t/60)
        data.append({'municipi': municipi, "Estancia Minima":duracio_hores })
        print(row['Municipi'])

    df = pd.read_excel(xlsx_file, sheet_name=3)
    
    for _, row in df.iterrows():
        municipi = row['Municipi']
        t = int(row['Estancia Minima'].strip().split()[0])
        duracio_hores = (t if "HORA" in row['Estancia Minima'] else t/60)
        data.append({'municipi': municipi, "Estancia Minima":duracio_hores })
        print(row['Municipi'])
    
    # Convert the data to a DataFrame and save as CSV
    output_df = pd.DataFrame(data)
    output_df.to_csv(output_csv, index=False)

# Example usage
xlsx_file = '../data/Dades_Municipis.xlsx'
output_csv = 'min_times.csv'
extract_min_time(xlsx_file, output_csv)
