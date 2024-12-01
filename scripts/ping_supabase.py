import requests
import os

SUPABASE_URL_DB = os.getenv("SUPABASE_URL_DB")
SUPABASE_ANON_KEY_DB = os.getenv("SUPABASE_ANON_KEY_DB")

def ping_database(url, anon_key, table_name, db_name):
    if not url or not anon_key:
        print(f"Les informations de connexion pour la base {db_name} ne sont pas définies.")
        return
    
    headers = {
        "apikey": anon_key,
        "Authorization": f"Bearer {anon_key}"
    }

    # Ping de la table spécifiée
    response = requests.get(f"{url}/rest/v1/{table_name}", headers=headers)
    
    if response.status_code == 200:
        print(f"Ping réussi pour {url}/{table_name} :", response.json())
    else:
        print(f"Erreur pour {db_name} :", response.status_code, response.text)

if __name__ == "__main__":

    print("=== Ping entre-2-traits (ping) ===")
    ping_database(SUPABASE_URL_DB, SUPABASE_ANON_KEY_DB, "ping", "entre-2-traits")
