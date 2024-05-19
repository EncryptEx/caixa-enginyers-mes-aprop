from flask import Flask

app = Flask(__name__)


@app.route("/")
def readFile():
    


@app.route("/generate")
def generate():
    pass


if __name__ == "__main__":
    app.run(debug=True)
