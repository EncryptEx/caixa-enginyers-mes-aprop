import json
from flask import Flask, jsonify, request

app = Flask(__name__)


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
        # print(feedback_responses['data'][0]['municipi'])
        
        return jsonify({'message': 'Data received successfully!'}), 200
    except Exception as e:
        return jsonify({'message': 'Failed to receive data', 'error': str(e)}), 400


if __name__ == "__main__":
    app.run(debug=True)
