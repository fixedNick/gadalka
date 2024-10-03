import asyncio
from typing import List
import undetected_chromedriver as uc
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.remote.webelement import WebElement
from selenium.webdriver.remote.webdriver import WebDriver
from selenium.webdriver.chrome.service import Service
import mysql.connector
import requests
from bs4 import BeautifulSoup as bs
import signal
import sys
import time
import os
import json
from datetime import datetime
import wait_for_it
import wait_for_it.wait_for_it

PERIOD_DAY = 1
PERIOD_MONTH = 2
PERIOD_YEAR = 3

def log(text: str) -> None:
    # if file logs.txt not exists create it
    if not os.path.exists('logs.txt'):
        open('logs.txt', 'w')
        
    log_text = f'[{time.strftime("%d-%m-%Y %H:%M:%S")}] {text}'
    print(log_text)
    # write log into file logs.txt
    with open('logs.txt', 'a') as file:
        file.write(log_text + '\n')

class Config:
    config_path = 'config.json'

    UpdateYearRequired: bool = False
    UpdateMonthRequired: bool = False
    UpdateDayRequired: bool = False

    def ReadConfig(self):

        log(f'Loading config from {self.config_path}')

        with open(self.config_path, 'r') as file:
            config_data = json.load(file)

        if config_data['last_update_year'] != datetime.now().year:
            self.UpdateYearRequired = True
            log(f'Required to update horoscope for year')

        if config_data['last_update_month'] != datetime.now().month:
            self.UpdateMonthRequired = True
            log(f'Required to update horoscope for month')

        if config_data['last_update_day'] != datetime.now().day:
            self.UpdateDayRequired = True
            log(f'Required to update horoscope for day')
    
        if self.UpdateDayRequired == False and self.UpdateMonthRequired == False and self.UpdateYearRequired == False:
            log('Config loaded. No need to update horoscope')
        else:
            log('Config successfully loaded')

    def UpdateLastUpdate(self):
        config_data = {}

        config_data['last_update_day'] = datetime.now().day
        config_data['last_update_month'] = datetime.now().month
        config_data['last_update_year'] = datetime.now().year

        with open(self.config_path, 'w') as file:      
            json.dump(config_data, file)

class Sign:
    id: int
    ru_name: str
    en_name: str
    def __init__(self, id: int, ru_name: str, en_name: str):
        self.id = id
        self.ru_name = ru_name
        self.en_name = en_name

def SendRequest(driver: WebDriver, messages: List[str]) -> List[WebElement]:
    # Общими словами
    time.sleep(3)
        
    driver.execute_script('document.querySelector(".ea0b6624").classList.add("_3162382");')
    time.sleep(2)
    
    for message in messages:
        driver.find_element(By.CSS_SELECTOR, '._71395a9').send_keys(message)
        time.sleep(3)
    time.sleep(3)
    driver.find_element(By.CSS_SELECTOR, '._71395a9').send_keys(Keys.ENTER)
    time.sleep(10)
    #read

    while True:
        toBreak = False
        for element in driver.find_elements(By.CSS_SELECTOR, '._125a28d'): 
            if "Send" in element.text:
                toBreak = True
                break
        
        if toBreak:
            break

        time.sleep(2)

    responseElements = driver.find_elements(By.CSS_SELECTOR,"#latest-context-divider ~ ._3074fe7._9e1dfb8:last-child p")
    return responseElements

def OpenConnection():
    connection = None
    try:
        connection = mysql.connector.connect(
            host=os.getenv('dbhost'),
            user=os.getenv('dbuser'),
            password=os.getenv('dbpass'),
            database=os.getenv('dbname'),
        )
    except mysql.connector.Error as err:
        log(f"SQL Error: {err}")
        
    return connection

def CloseConnection(connection, cursor = None): 
    if cursor is not None:
        cursor.close()
    if connection is not None and connection.is_connected():
        connection.close()

def ClearPeriod(period, sign: Sign):
    try: 
        connection = OpenConnection()
        cursor = connection.cursor()

        sql = "DELETE FROM horoscope WHERE period = %s AND sign_id = %s"
        val = (period, sign.id)

        cursor.execute(sql, val)
        connection.commit()
    except mysql.connector.Error as err:
        log(f"SQL Error: {err}")
    finally:
        CloseConnection(connection, cursor)

    log(f'Cleared period for `{sign.ru_name}/{sign.en_name}`[{sign.id}] on {period == PERIOD_MONTH and "MONTH" or (period == PERIOD_YEAR and "YEAR" or "DAY")}.')

def SaveRows(sign: Sign, period, lines: List[str], start_from_idx: int = 0) -> int:

    idx = start_from_idx
    for line in lines: 
        idx += 1
        try:
            connection = OpenConnection()
            cursor = connection.cursor()

            sql = "INSERT INTO horoscope (id, sign_id, html_tag, html_value, on_page_idx, period, last_update_date) VALUES ('0', %s, %s, %s, %s, %s, %s)"
            
            html_value = line
            val = (sign.id, 'p', html_value, idx, period, datetime.now().strftime("%d-%m-%Y"))

            cursor.execute(sql, val)
            connection.commit()
        except mysql.connector.Error as err:
            log(f"SQL Error: {err}")
        finally:
            CloseConnection(connection, cursor)

    log(f'Added horoscope for `{sign.ru_name}/{sign.en_name}`[{sign.id}] on {period == PERIOD_MONTH and "MONTH" or (period == PERIOD_YEAR and "YEAR" or "DAY")}. Total paragragps: {idx-start_from_idx}')
    return idx - start_from_idx

def GetHoroscopeToday(en_sign_name: str) -> str:
    link = f'https://horo.mail.ru/prediction/{en_sign_name}/today/'
    resp = requests.get(link)
    soup = bs(resp.text, 'html.parser')
    return soup.select_one('main[itemprop=articleBody]').text

def GetHoroscopeMonth(en_sign_name: str) -> str:
    link = f'https://horo.mail.ru/prediction/{en_sign_name}/month/'
    resp = requests.get(link)
    soup = bs(resp.text, 'html.parser')
    return soup.select_one('main[itemprop=articleBody]')

def GetHoroscopeYear(en_sign_name: str) -> str:
    link = f'https://horo.mail.ru/prediction/{en_sign_name}/year/'
    resp = requests.get(link)
    soup = bs(resp.text, 'html.parser')
    return soup.select_one('main[itemprop=articleBody]')

def GPTAuth(driver: WebDriver, email, pwd):
    driver.set_page_load_timeout(120)
    driver.get('https://chat.deepseek.com/sign_in')

    driver.find_element(By.CSS_SELECTOR, '#root > div > div._1e91608 > div > div:nth-child(2) > div.ds-form-item__content > div > input').send_keys(email)
    time.sleep(1.5)
    driver.find_element(By.CSS_SELECTOR, '#root > div > div._1e91608 > div > div:nth-child(3) > div.ds-form-item__content > div > input').send_keys(pwd)
    time.sleep(1.5)
    driver.find_element(By.CSS_SELECTOR, "#root > div > div._1e91608 > div > div:nth-child(4) > div.ds-form-item__content > div > div.ds-checkbox-align-wrapper > div").click()
    time.sleep(1.5)
    driver.find_element(By.CSS_SELECTOR, "#root > div > div._1e91608 > div > div.ds-button.ds-button--primary.ds-button--filled.ds-button--rect.ds-button--block.ds-button--l.ds-sign-up-form__register-button").click()

def GetSignsList() -> List[Sign]:
    sign_list = []
    try:
        db = OpenConnection()
        cursor = db.cursor()
        sql = "SELECT id, sign_ru, sign_en FROM signs"
        cursor.execute(sql)

        rows = cursor.fetchall()

        for row in rows:
            sign_list.append(Sign(row[0], row[1], row[2]))
    except mysql.connector.Error as err:
        log(f"SQL Error: {err}")
    finally:
        CloseConnection(db, cursor)

    return sign_list
    
def main():
    log("Horoscope Microservice STARTED")

    config = Config()
    config.ReadConfig()

    try:
        service = Service(executable_path="/app/chromedriver")
        driver = uc.Chrome(headless=True, no_sandbox=True, port=9515, service=service)
    except Exception as e:
        log(f"Error on starting Chrome: {e}")
        exit(1)
        return

    GPTAuth(driver, os.getenv('API_USERNAME'), os.getenv('API_PASSWORD'))

    sign_list = GetSignsList()
    
    for sign in sign_list:
        if config.UpdateDayRequired:
            baseHoroscope = GetHoroscopeToday(sign.en_name)

            response = SendRequest(driver,
            [
                f'Мне нужно, чтобы ты перефразировал своими словами гороскоп для знака {sign.ru_name}, который я тебе приведу ниже. Постарайся расписать его на 2 - 3 параграфа. Между параграфами поставь такие знаки: ]H!H!H[',
                f'Гороскоп для знака {sign.ru_name}, который нужно написать своими словами: {baseHoroscope}'
            ])

            full_response = ''
            for element in response:
                full_response += element.text

            paragraphs = full_response.split(']H!H!H[')
            ClearPeriod(PERIOD_DAY, sign)
            SaveRows(sign, PERIOD_DAY, paragraphs, 0)
        
        if config.UpdateMonthRequired:
            baseHoroscope = GetHoroscopeMonth(sign.en_name)

            response = SendRequest(driver,
            [
                f'Мне нужно, чтобы ты перефразировал своими словами гороскоп для знака {sign.ru_name}, который я тебе приведу ниже. Постарайся расписать его на 2 - 4 параграфа. Между параграфами поставь такие знаки: ]H!H!H[',
                f'Гороскоп для знака на месяц {sign.ru_name}, который нужно написать своими словами: {baseHoroscope}'
            ])

            full_response = ''
            for element in response:
                full_response += element.text

            paragraphs = full_response.split(']H!H!H[')
            ClearPeriod(PERIOD_MONTH, sign)
            SaveRows(sign, PERIOD_MONTH, paragraphs, 0)

        if config.UpdateYearRequired:
            baseHoroscope = GetHoroscopeYear(sign.en_name)

            response = SendRequest(driver,
            [
                f'Мне нужно, чтобы ты перефразировал своими словами гороскоп для знака {sign.ru_name}, который я тебе приведу ниже. Постарайся расписать его на 2 - 4 параграфа. Между параграфами поставь такие знаки: ]H!H!H[',
                f'Гороскоп для знака на год {sign.ru_name}, который нужно написать своими словами: {baseHoroscope}'
            ])

            full_response = ''
            for element in response:
                full_response += element.text

            paragraphs = full_response.split(']H!H!H[')
            ClearPeriod(PERIOD_YEAR, sign)
            SaveRows(sign, PERIOD_YEAR, paragraphs, 0)

    config.UpdateLastUpdate()
    driver.quit()

if __name__ == "__main__":
    log('Horoscope Microservice started. Waiting for db startup...')
    r = asyncio.run(wait_for_it.wait_for_it._wait_until_available(os.getenv('dbhost'), 3306))
    log('DB started. Starting horoscope microservice...')
    main()