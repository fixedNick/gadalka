from typing import List
import undetected_chromedriver as uc
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.remote.webelement import WebElement
from selenium.webdriver.remote.webdriver import WebDriver
import mysql.connector
import requests
from bs4 import BeautifulSoup as bs
import time

# Знаки зодиака
ru_signs = [
    'Овен', 'Телец', 'Близнецы', 'Рак', 'Лев', 'Дева', 'Весы', 'Скорпион', 'Стрелец', 'Козерог', 'Водолей', 'Рыбы'
]
signs = [
    'aries', 'taurus', 'gemini', 'cancer', 'leo', 'virgo', 'libra', 'scorpio', 'sagittarius', 'capricorn', 'aquarius', 'pisces'
]

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

    responseElements = driver.find_elements(By.CSS_SELECTOR,"#latest-context-divider ~ ._3074fe7._9e1dfb8:last-child p ,#latest-context-divider ~ ._3074fe7._9e1dfb8:last-child h3")
    return responseElements

def OpenConnection():
    mydb = mysql.connector.connect(
        host="localhost",
        user="root",
        password="root",
        database="taro"
    )
    return mydb

def CloseConnection(db): 
    db.close()

def SaveRows(db, s1, s2, elements: List[WebElement], start_from_idx: int = 0) -> int:
    mycursor = db.cursor()

    idx = start_from_idx
    for element in elements: 
        sql = "INSERT INTO love (id, s1, s2, html_tag, html_value, on_page_idx) VALUES ('0', %s, %s, %s, %s, %s)"

        idx += 1
        tag = 'p'
        strongText = ''
        pText = ''
        if element.tag_name == "p":
            tag = 'p'
            try:
                strongText = element.find_element(By.CSS_SELECTOR, 'strong').text.strip()
                val = (s1,s2, 'h3', strongText, idx)
                idx += 1
                mycursor.execute(sql, val)
                db.commit()
                print(mycursor.rowcount, "record inserted.")
                pText = element.text.strip().replace(strongText, '').strip()
                pText = pText.replace('<strong>', '')
                pText = pText.replace('</strong>', '')
            except:
                strongText = None
                pText = element.text

        elif element.tag_name == "h3":
            tag = 'h4'
            pText = element.text.strip()

        val = (s1, s2, tag, pText, idx)
        mycursor.execute(sql, val)
        db.commit()
        print(mycursor.rowcount, "record inserted.")
    
    return idx


def GetHoroscopeToday(sign):
    link = f'https://horo.mail.ru/prediction/{sign}/today/'
    resp = requests.get(link)
    soup = bs(resp.text, 'html.parser')
    return soup.select_one('main[itemprop=articleBody]').text

def main():
    driver = uc.Chrome(headless=False, no_sandbox=True)
    driver.set_page_load_timeout(120)
    driver.get('https://chat.deepseek.com/sign_in')
    input()
    for i in range(12):
        sign = signs[i]
        baseHoroscope = GetHoroscopeToday(sign)

        response = SendRequest(driver, [
            f'Мне нужно, чтобы ты перефразировал своими словами гороскоп для знака {ru_signs[i]}, который я тебе приведу ниже. Постарайся расписать его на 2 - 3 параграфа. Между параграфами поставь такие знаки: ]H!H!H[.',
            f'Гороскоп для знака {ru_signs[i]}, который нужно написать своими словами: {baseHoroscope}'
        ])

        print('Horoscope for ' + ru_signs[i] + ':')
        for element in response:
            print(element.text)

if __name__ == "__main__":
    main()