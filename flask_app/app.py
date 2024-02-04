# flask_app/app.py
from flask import Flask, request, jsonify
import xml.etree.ElementTree as ET
import random
from flask_cors import CORS

app = Flask(__name__)

CORS(app)

# Inisialisasi XML tree dan root
tree = ET.parse('../storage/app/public/chatbot.xml')
root = tree.getroot()

def process_random_element(random_element):
    options = random_element.findall('li')
    if options:
        selected_option = random.choice(options)
        return selected_option.text.strip()
    return "Tidak ada pilihan yang tersedia."

def get_aiml_response(user_input):
    for category in root.findall(".//category"):
        pattern = category.find('pattern').text
        if user_input.lower() == pattern.lower():
            template = category.find('template')
            random_element = template.find('random')
            if random_element is not None:
                return process_random_element(random_element)
            return template.text.strip()
    return "Saya tidak mengerti pertanyaan Anda."

@app.route('/process_aiml', methods=['POST'])
def chat():
    user_input = request.json.get('user_input')
    if not user_input:
        return jsonify(error="Input tidak boleh kosong"), 400

    response = get_aiml_response(user_input)
    return jsonify(response=response)

if __name__ == '__main__':
    app.run(debug=True)
