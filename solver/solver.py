import json
from bloc_solver import solve_bloc
import pandas as pd

jsn = []
lots = [2]#, 4, 5]

dates = ["2024-05-20T08:00:00+02:00", "2024-05-27T08:00:00+02:00", "2024-06-03T08:00:00+02:00", "2024-06-10T08:00:00+02:00"]
for lot in lots:
    ciutats_lot = pd.read_excel('../data/Dades_Municipis.xlsx', sheet_name=lot)
    for bloc, _ in ciutats_lot.groupby('BLOC'):
        r = solve_bloc(4, 2, dates[bloc-1])
        jsn.extend(r)
print(r)

output_file = 'sol.json'
with open(output_file, 'w') as f:
    json.dump(r, f, indent=2)