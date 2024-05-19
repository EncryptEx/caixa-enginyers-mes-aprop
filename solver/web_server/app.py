import json
from flask import Flask, jsonify, request
from flask_cors import CORS

app = Flask(__name__)

CORS(app)


@app.route("/")
def readFile():
    # read file
    # return file content
    with open("solucio.json", "r") as file:
        data = json.load(file)
    return jsonify(data)


@app.route("/generate", methods=["POST"])
def generate():
    global feedback_responses
    try:
        # Get the JSON data from the request
        data = request.get_json()

        # Store the JSON data in the feedback_responses variable
        # HERE YOU HAVE THE DATA:
        feedback_responses = data

        # Print the feedback_responses variable to verify
        # print(json.dumps(feedback_responses, indent=4))
        print(feedback_responses)

        return jsonify({"message": "Data received successfully!"}), 200
    except Exception as e:
        return jsonify({"message": "Failed to receive data", "error": str(e)}), 400


# create a function that given a city name returns the lat and lon
@app.route("/discover/<city_name>")
def discover(city_name):
    with open("coords.json", "r") as file:
        data = json.load(file)
    # print(data)
    for city in data:
        if city["municipi"].lower() == city_name.lower().replace("%20", " ").replace(
            "&#039;", "'"
        ):
            return jsonify({"lat": city["latitude"], "lon": city["longitude"]})
    return jsonify({"error": "City not found"}), 404


if __name__ == "__main__":
    app.run(debug=True)
