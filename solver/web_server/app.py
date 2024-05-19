from flask import Flask, jsonify

app = Flask(__name__)


@app.route("/")
def readFile():
    # read file
    # return file content
    with open('data.json', 'r') as file:
        data = file.read()
    return jsonify(data)




@app.route("/generate")
def generate():
    pass


if __name__ == "__main__":
    app.run(debug=True)
