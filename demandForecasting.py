#C:\Users\name\AppData\Local\Programs\Python\Python312\python.exe

import sys
import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestRegressor
from sklearn.metrics import mean_squared_error

prediction_year = sys.argv #prediction year from php (if this got error try sys.argv[1])

#dataset
dataset = pd.read_csv('Datasets For Intelligent Meter - Inventory Management System\meterdemand.csv')

faulty_program_model = RandomForestRegressor()
meter_complaint_model = RandomForestRegressor()
meter_leak_model = RandomForestRegressor()

X = dataset [['Month', 'Year']]
y_faulty_program = dataset['Faulty Program']  
y_meter_complaint = dataset['Meter Complaint']  
y_meter_leak = dataset['Meter Leak']

X_train, X_test, y_faulty_program_train, y_faulty_program_test, y_meter_complaint_train, y_meter_complaint_test, y_meter_leak_train, y_meter_leak_test = train_test_split(X, y_faulty_program, y_meter_complaint, y_meter_leak, test_size=0.2, random_state=42)

faulty_program_model.fit(X_train, y_faulty_program_train)
meter_complaint_model.fit(X_train, y_meter_complaint_train)
meter_leak_model.fit(X_train, y_meter_leak_train)

y_pred_faulty_program = faulty_program_model.predict(X_test)
mse_faulty_program = mean_squared_error(y_faulty_program_test, y_pred_faulty_program)
print("Mean Squared Error for Faulty Program:", mse_faulty_program)

y_pred_meter_complaint = meter_complaint_model.predict(X_test)
mse_meter_complaint = mean_squared_error(y_meter_complaint_test, y_pred_meter_complaint)
print("Mean Squared Error for Meter Complaint:", mse_meter_complaint)

y_pred_meter_leak = meter_leak_model.predict(X_test)
mse_meter_leak = mean_squared_error(y_meter_leak_test, y_pred_meter_leak)
print("Mean Squared Error for Meter Leak:", mse_meter_leak)

#creating timeframe for prediction
months = range(1, 13)
future_timeframe = pd.DataFrame({'Month': months, 'Year': [int(prediction_year) for i in range(1, 13)]})

future_faulty_program = faulty_program_model.predict(future_timeframe)
future_meter_complaint = meter_complaint_model.predict(future_timeframe)
future_meter_leak = meter_leak_model.predict(future_timeframe)

ar = []
for i in future_faulty_program:
    ar.append(i)
for i in future_meter_complaint:
    ar.append(i)
for i in future_meter_leak:
    ar.append(i)

print(ar)