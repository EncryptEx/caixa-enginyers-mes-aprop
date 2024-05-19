import json
from flask import Flask, jsonify

app = Flask(__name__)


@app.route("/")
def readFile():
    # read file
    # return file content
    with open('solucio.json', 'r') as file:
        data = json.load(file)
    return jsonify(data)




@app.route("/generate")
def generate():
    pass


if __name__ == "__main__":
    app.run(debug=True)
