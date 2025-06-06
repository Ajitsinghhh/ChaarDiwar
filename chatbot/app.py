from flask import Flask, request, jsonify
from flask_cors import CORS
import requests

app = Flask(__name__)
CORS(app)  # Enable CORS for frontend communication

# Replace with your actual API details
BASE_API_URL = "https://api.langflow.astra.datastax.com"
LANGFLOW_ID = "67d63ac0-2e7c-436c-868e-368b6c7a33b7"
FLOW_ID = ""
APPLICATION_TOKEN = ""

def run_flow(message):
    api_url = f"{BASE_API_URL}/lf/{LANGFLOW_ID}/api/v1/run/{FLOW_ID}"
    
    payload = {
        "input_value": message,
        "output_type": "chat",
        "input_type": "chat",
    }
    
    headers = {
        "Authorization": f"Bearer {APPLICATION_TOKEN}",
        "Content-Type": "application/json"
    }
    
    try:
        response = requests.post(api_url, json=payload, headers=headers)
        response_json = response.json()
        
        print("API Response:", response_json)  # Debugging purpose
        
        # Extract chatbot reply safely
        chatbot_reply = (
            response_json.get("outputs", [{}])[0]
            .get("outputs", [{}])[0]
            .get("results", {})
            .get("message", {})
            .get("text", "Sorry, I couldn't process that.")
        )
    
    except Exception as e:
        print("Error parsing response:", e)
        chatbot_reply = "Error processing the request."

    return chatbot_reply

@app.route("/chat", methods=["POST"])
def chat():
    data = request.get_json()
    user_message = data.get("message", "").strip()

    if not user_message:
        return jsonify({"error": "No message provided"}), 400

    bot_reply = run_flow(user_message)
    
    return jsonify({"reply": bot_reply})

if __name__ == "__main__":
    app.run(debug=True)
