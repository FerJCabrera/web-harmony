import sys
import time
import os
from bs4 import BeautifulSoup
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
import pandas as pd
from datetime import datetime

def web_scraping(url, test_type, credentials_or_search_term, file_name):
    data = []
    driver_path = './chromedriver_win32/chromedriver.exe'  # Ruta del ChromeDriver

    service = Service(driver_path)
    options = webdriver.ChromeOptions()
    
    driver = webdriver.Chrome(service=service, options=options)
    driver.get(url)
    
    if test_type == 'search':
        search_term = credentials_or_search_term
        try:
            # Intentar encontrar el campo de entrada por nombre
            search_bar = driver.find_element(By.NAME, 'q')
        except Exception as e:
            print(f"No se encontró el campo de búsqueda por nombre: {e}")
            # Intentar encontrar cualquier campo de entrada de tipo "search"
            try:
                search_bar = driver.find_element(By.CSS_SELECTOR, 'input[type="search"]')
            except Exception as e:
                print(f"No se encontró el campo de búsqueda por nombre: {e}")
            try:
                search_bar = driver.find_element(By.CSS_SELECTOR, 'input[type="text"]')
            except Exception as e:
                print(f"No se encontró el campo de búsqueda por tipo: {e}")
                search_bar = None

        if search_bar:
            try:
                search_bar.send_keys(search_term)
                search_bar.send_keys(Keys.RETURN)
                time.sleep(3)
                
                soup = BeautifulSoup(driver.page_source, 'html.parser')
                results = soup.find_all('div', class_='s-main-slot s-result-list s-search-results sg-row')
                for result in results:
                    title_elements = result.find_all('span', class_='a-size-medium a-color-base a-text-normal')
                    for title_element in title_elements:
                        title = title_element.text
                        link = title_element.find_parent('a')['href']
                        timestamp = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
                        data.append({'Element Type': 'Search Result', 'Details': title, 'Link': 'https://www.amazon.com.mx' + link, 'Timestamp': timestamp})
            except Exception as e:
                print(f"Error al usar el campo de búsqueda: {e}")

    elif test_type == 'create_account':
        email, password, username = credentials_or_search_term.split(',')
        try:
            driver.find_element(By.NAME, 'email').send_keys(email)
            driver.find_element(By.NAME, 'password').send_keys(password)
            driver.find_element(By.NAME, 'username').send_keys(username)
            driver.find_element(By.NAME, 'submit').click()
            time.sleep(3)
            
            success_message = driver.find_element(By.ID, 'success')
            timestamp = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            data.append({'Element Type': 'Registration Success', 'Details': success_message.text, 'Timestamp': timestamp})

        except Exception as e:
            print(f"No se encontró el formulario de registro: {e}")

    # Realizar web scraping general en la URL, independientemente del éxito o fracaso de la prueba
    try:
        soup = BeautifulSoup(driver.page_source, 'html.parser')
        
        # Registrar encabezados
        headers = soup.find_all(['h1', 'h2', 'h3', 'h4', 'h5', 'h6'])
        for header in headers:
            header_text = header.text.strip()
            timestamp = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            data.append({'Element Type': 'Header', 'Details': header_text, 'Timestamp': timestamp})
        
        # Registrar campos de entrada
        inputs = soup.find_all('input')
        for input_field in inputs:
            input_type = input_field.get('type', 'text')
            input_name = input_field.get('name', 'unnamed')
            timestamp = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            data.append({'Element Type': 'Input Field', 'Details': f'Type: {input_type}, Name: {input_name}', 'Timestamp': timestamp})
        
        # Registrar botones
        buttons = soup.find_all('button')
        for button in buttons:
            button_text = button.text.strip()
            timestamp = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            data.append({'Element Type': 'Button', 'Details': button_text, 'Timestamp': timestamp})

    except Exception as e:
        print(f"Error durante el web scraping general: {e}")
    
    # Guardar los datos en un archivo CSV
    df = pd.DataFrame(data)
    df.to_csv(file_name, index=False)

    # Proceder a la subida del archivo
    try:
        # Navegar a la página de inicio de sesión e iniciar sesión
        driver.get('http://localhost/projectsend/index.php')
        time.sleep(3)
        driver.find_element(By.ID, 'username').send_keys('harmonyUploader')
        driver.find_element(By.ID, 'password').send_keys('harmony')
        driver.find_element(By.ID, 'btn_submit').click()
        time.sleep(3)

        # Navegar a la página de subida de archivos
        driver.get('http://localhost/projectsend/upload.php')
        time.sleep(3)

        # Subir el archivo generado
        file_input = driver.find_element(By.CSS_SELECTOR, "input[type='file']")
        file_input.send_keys(os.path.abspath(file_name))
        time.sleep(1)
        driver.find_element(By.ID, 'btn-submit').click()
        time.sleep(3)

        # Navegar a files-edit.php y continuar
        driver.get('http://localhost/projectsend/files-edit.php')
        time.sleep(3)
        driver.find_element(By.ID, 'upload-continue').click()
        time.sleep(3)
    
    except Exception as e:
        print(f"Error durante la subida del archivo: {e}")
    
    finally:
        driver.quit()
    
    return file_name

if __name__ == "__main__":
    url = sys.argv[1]
    test_type = sys.argv[2]
    credentials_or_search_term = sys.argv[3]
    file_name = sys.argv[4]
    csv_file = web_scraping(url, test_type, credentials_or_search_term, file_name)
    print(csv_file)
