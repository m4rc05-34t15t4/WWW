import time
import requests

# URL da API para listar as corretoras
url_list = "https://api.coingecko.com/api/v3/exchanges"

# Fazendo a requisição para obter a lista de corretoras
response_list = requests.get(url_list)
exchanges = response_list.json()

lista = {}

print(len(exchanges))

# Iterando sobre as corretoras e obtendo informações detalhadas
for exchange in exchanges:  # Limite para as 5 primeiras corretoras como exemplo
    exchange_id = exchange['id']
    
    # URL da API para obter detalhes da corretora específica
    url_detail = f"https://api.coingecko.com/api/v3/exchanges/{exchange_id}"
    response_detail = requests.get(url_detail)
    exchange_detail = response_detail.json()
    
    # Obtendo a imagem (logo) da corretora
    image_url = exchange_detail.get('image')
    name = exchange_detail.get('name')
    
    lista[exchange_id] = [name, image_url]
    
    print(f"Corretora: {name} - Imagem: {image_url}\n")
    
    time.sleep(1.2)
    
print(lista)
