from flask import Flask, request, jsonify
from rapoActeur import rapoActeur
from rapoFilm import rapoFilm
from trouver import trouver
from config import get_db_config

app = Flask(__name__)

@app.route('/test', methods=['GET'])
def test():
    result = {'Message': 'ALL GOOD'}
    return jsonify(result)

@app.route('/result', methods=['POST'])
def result():
    dbConfig = get_db_config()
    data = request.get_json()
    if 'nconst1' in data and 'nconst2' in data:
        rapprochement = rapoActeur(nconstDebut=data['nconst1'], nconstFin=data['nconst2'], mode=data["mode"], config=dbConfig)
        result = rapprochement.Start()
        return jsonify(result)
    
    elif 'tconst1' in data and 'tconst2' in data:
        rapprochement = rapoFilm(tconstDebut=data['tconst1'], tconstFin=data['tconst2'], mode=data["mode"], config=dbConfig)
        result = rapprochement.Start()
        return jsonify(result)
    else:
        result = {'status': 'Erreur', 'message': 'Données manquantes ou erronées'}
        return jsonify(result), 400  

@app.route('/trouver', methods=['POST'])
def resultTrouver():
    dbConfig = get_db_config()
    data = request.get_json()
    if data['element1'] and data['element2']:
        trouverObject = trouver(element1=data['element1'], element2=data['element2'], config=dbConfig)
        result = trouverObject.main()
        return jsonify(result)
    else :
        result = {'status': 'Erreur', 'message': 'Données manquantes ou erronées'}
        return jsonify(result), 400


if __name__ == "__main__":
    app.run(debug=True, port=5001)
