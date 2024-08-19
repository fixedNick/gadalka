from typing import List
import undetected_chromedriver as uc
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.remote.webelement import WebElement
from selenium.webdriver.remote.webdriver import WebDriver
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import json, requests

import mysql.connector

import time

cards = [ 
    ('Дурак', 'The Fool'),
    ('Маг', 'The Magician'),
    ('Верховная Жрица', 'The High Priestess'),
    ('Императрица', 'The Empress'),
    ('Император', 'The Emperor'),
    ('Иерофант', 'The Hierophant'),
    ('Влюбленные', 'The Lovers'),
    ('Колесница', 'The Chariot'),
    ('Сила', 'Strength'),
    ('Отшельник', 'The Hermit'),
    ('Колесо Фортуны', 'The Wheel of Fortune'),
    ('Справедливость', 'Justice'),
    ('Повешенный', 'The Hanged Man'),
    ('Смерть', 'Death'),
    ('Умеренность', 'Temperance'),
    ('Дьявол', 'The Devil'),
    ('Башня', 'The Tower'),
    ('Звезда', 'The Star'),
    ('Луна', 'The Moon'),
    ('Солнце', 'The Sun'),
    ('Суд', 'Judgement'),
    ('Мир', 'The World'),
    ('Туз Пентаклей', 'Ace of Pentacles'),
    ('Двойка Пентаклей', 'Two of Pentacles'),
    ('Тройка Пентаклей', 'Three of Pentacles'),
    ('Четверка Пентаклей', 'Four of Pentacles'),
    ('Пятерка Пентаклей', 'Five of Pentacles'),
    ('Шестерка Пентаклей', 'Six of Pentacles'),
    ('Семерка Пентаклей', 'Seven of Pentacles'),
    ('Восьмерка Пентаклей', 'Eight of Pentacles'),
    ('Девятка Пентаклей', 'Nine of Pentacles'),
    ('Десятка Пентаклей', 'Ten of Pentacles'),
    ('Паж Пентаклей', 'Page of Pentacles'),
    ('Рыцарь Пентаклей', 'Knight of Pentacles'),
    ('Королева Пентаклей', 'Queen of Pentacles'),
    ('Король Пентаклей', 'King of Pentacles'),
    ('Туз Мечей', 'Ace of Swords'),
    ('Двойка Мечей', 'Two of Swords'),
    ('Тройка Мечей', 'Three of Swords'),
    ('Четверка Мечей', 'Four of Swords'),
    ('Пятерка Мечей', 'Five of Swords'),
    ('Шестерка Мечей', 'Six of Swords'),
    ('Семерка Мечей', 'Seven of Swords'),
    ('Восьмерка Мечей', 'Eight of Swords'),
    ('Девятка Мечей', 'Nine of Swords'),
    ('Десятка Мечей', 'Ten of Swords'),
    ('Паж Мечей', 'Page of Swords'),
    ('Рыцарь Мечей', 'Knight of Swords'),
    ('Королева Мечей', 'Queen of Swords'),
    ('Король Мечей', 'King of Swords'),
    ('Туз Жезлов', 'Ace of Wands'),
    ('Двойка Жезлов', 'Two of Wands'),
    ('Тройка Жезлов', 'Three of Wands'),
    ('Четверка Жезлов', 'Four of Wands'),
    ('Пятерка Жезлов', 'Five of Wands'),
    ('Шестерка Жезлов', 'Six of Wands'),
    ('Семерка Жезлов', 'Seven of Wands'),
    ('Восьмерка Жезлов', 'Eight of Wands'),
    ('Девятка Жезлов', 'Nine of Wands'),
    ('Десятка Жезлов', 'Ten of Wands'),
    ('Паж Жезлов', 'Page of Wands'),
    ('Рыцарь Жезлов', 'Knight of Wands'),
    ('Королева Жезлов', 'Queen of Wands'),
    ('Король Жезлов', 'King of Wands'),
    ('Туз Кубков', 'Ace of Cups'),
    ('Двойка Кубков', 'Two of Cups'),
    ('Тройка Кубков', 'Three of Cups'),
    ('Четверка Кубков', 'Four of Cups'),
    ('Пятерка Кубков', 'Five of Cups'),
    ('Шестерка Кубков', 'Six of Cups'),
    ('Семерка Кубков', 'Seven of Cups'),
    ('Восьмерка Кубков', 'Eight of Cups'),
    ('Девятка Кубков', 'Nine of Cups'),
    ('Десятка Кубков', 'Ten of Cups'),
    ('Паж Кубков', 'Page of Cups'),
    ('Рыцарь Кубков', 'Knight of Cups'),
    ('Королева Кубков', 'Queen of Cups'),
    ('Король Кубков', 'King of Cups'),]

def translate(data):

    url = 'https://translate.api.cloud.yandex.net/translate/v2/translate'
    api_key = 'AQVN1KCLuEcQPTxEaPz-6M-WcLszcWn0aztsH_cv'

    # Преобразуем данные в формат JSON
    json_data = json.dumps({'sourceLanguageCode': 'en', 'targetLanguageCode': 'ru','texts': [data]})
    
    # Заголовки запроса
    headers = {
        'Content-Type': 'application/json',
        'Authorization': f'Api-Key {api_key}'
    }
    
    # Отправка POST-запроса
    response = requests.post(url, headers=headers, data=json_data)
    
    # Проверка ответа
    if response.status_code == 200:
        return response.json()['translations'][0]['text']
    else:
        print("Ошибка при отправке запроса. Статус код:", response.status_code)
        print("Текст ошибки:", response.text)

def GetKeywords(driver: WebDriver, column_title: str) -> List[str]:

    tables = driver.find_elements(By.CSS_SELECTOR, "table:has(td)")
    for table in tables:
        rows = table.find_elements(By.CSS_SELECTOR, 'tr')
        for row in rows:
            cells = row.find_elements(By.CSS_SELECTOR, 'td')
            for cell in cells:
                if column_title in cell.text.strip():
                    targetCellIndex = cells.index(cell)
                    currentRowIndex = rows.index(row)
                    keywords = []
                    parsed = rows[currentRowIndex + 1].find_elements(By.CSS_SELECTOR, 'td')[targetCellIndex].text.split(',')
                    for keyword in parsed:
                        if len(keyword.strip()) == 0:
                            continue

                        keywords.append(translate(keyword.strip()))

                    if len(keywords) == 0:
                        print('found 0 keywords for: ' + column_title)
                    return keywords

    raise Exception()
    
def GetParagraphByTitleThatContains(content: List[WebElement], words: List[str]) -> List[str]:
    paragraphs : List[str] = []
    finished = False
    for line in content:
        if line.tag_name == 'h1' or line.tag_name == 'h2':
            if finished:
                break
            if all(word in line.text for word in words):
                finished = True
                continue
        
        if line.tag_name == 'p' and finished: 
            if len(line.text.strip()) == 0:
                continue

            paragraphs.append(translate(line.text.strip()))

    return paragraphs

def DriverParseLink(driver: WebDriver, link: str) -> None:
    driver.get(link)
    time.sleep(5)

    content = driver.find_elements(By.CSS_SELECTOR, '.rte.rte--indented-images.content > p, .rte.rte--indented-images.content h1, .rte.rte--indented-images.content > h2')

    # get card name
    enCardName = driver.find_element(By.CSS_SELECTOR, 'h1[itemprop=headline]').text
    enCardName = enCardName[0:enCardName.find(' Meaning')]
    print('Card name: ' + enCardName)

    ruCardName = ''
    for card in cards:
        if card[1].lower() == enCardName.lower():
            ruCardName = card[0]
            break

    print('[RU] Card name: ' + ruCardName)
    # get card description
    description = (GetParagraphByTitleThatContains(content,['Tarot Card Description']))

    # get upgight keywords
    uprightKeywords = GetKeywords(driver, 'Upright Keywords')
    # get reversed keywords
    reversedKeywords = GetKeywords(driver, 'Reversed Keywords')

    # get upright meaning
    uprightMeaning = (GetParagraphByTitleThatContains(content,['Upright', 'Meaning']))
    # get reversed meaning
    reversedMeaning = (GetParagraphByTitleThatContains(content,['Reversed', 'Meaning']))

    # get love upright keywords
    loveUprightKeywords = GetKeywords(driver, 'Upright Love Meaning')
    # get career upright keywords
    careerUprightKeywords = GetKeywords(driver, 'Upright Career Meaning')
    # get finance upright keywords
    financeUprightKeywords = GetKeywords(driver, 'Upright Finances Meaning')

    # get love reversed keywords
    loveReversedKeywords = GetKeywords(driver, 'Reversed Love Meaning')
    # get career reversed keywords
    careerReversedKeywords = GetKeywords(driver, 'Reversed Career Meaning')
    # get finance reversed keywords
    financeReversedKeywords = GetKeywords(driver, 'Reversed Finances Meaning')

    # get love upright meaning
    loveUprightMeaning = (GetParagraphByTitleThatContains(content,['Upright', 'Tarot', 'Meaning', 'Love']))
    # get career upright meaning
    careerUprightMeaning = (GetParagraphByTitleThatContains(content,['Upright', 'Meaning', 'Career']))
    # get finance upright meaning
    financeUprightMeaning = (GetParagraphByTitleThatContains(content,['Upright', 'Meaning', 'Finances']))

    # get love reversed meaning
    loveReversedMeaning = (GetParagraphByTitleThatContains(content,['Reversed', 'Tarot', 'Meaning', 'Love']))
    # get career reversed meaning
    careerReversedMeaning = (GetParagraphByTitleThatContains(content,['Reversed', 'Meaning', 'Career']))
    # get finance reversed meaning
    financeReversedMeaning = (GetParagraphByTitleThatContains(content,['Reversed', 'Meaning', 'Finances']))


    # Add card into database and receive auto-incremented id of card
    id = AddCard(enCardName, ruCardName, uprightKeywords, reversedKeywords, loveUprightKeywords, loveReversedKeywords, careerUprightKeywords, careerReversedKeywords, financeUprightKeywords, financeReversedKeywords)

    # then add all of descriptions into another db `single_card_desc`
    AddCardDesc(id, description, 9)
    AddCardDesc(id, uprightMeaning, 1)
    AddCardDesc(id, reversedMeaning, 2)
    AddCardDesc(id, loveUprightMeaning, 3)
    AddCardDesc(id, loveReversedMeaning, 4)
    AddCardDesc(id, careerUprightMeaning, 5)
    AddCardDesc(id, careerReversedMeaning, 6)
    AddCardDesc(id, financeUprightMeaning, 7)
    AddCardDesc(id, financeReversedMeaning, 8)


# returns updated on_page_index
def AddCardDesc(id: int, desc: List[str], type: int) -> None:
    mydb = mysql.connector.connect(
        host="localhost",
        user="root",
        password="root",
        database="taro"
    )
    mycursor = mydb.cursor()

    current_on_page_index = 0
    for d in desc:
        sql = "INSERT INTO single_card_desc (card_id, desc_type, desc_value, on_page_index) VALUES (%s,%s,%s,%s)"
        val = (id, type, d, current_on_page_index)
        current_on_page_index += 1

        mycursor.execute(sql, val)
        mydb.commit()
    
    mydb.close()

def strFromArr(arr: List[str]) -> str:
    res = ''
    for l in arr:
        res += l + ','
    res = res[:-1]
    return res
def AddCard(en_name,ru_name, up_keywords: List[str], rev_keywords, love_up_keywords, love_rev_keywords, career_up_keywords, career_rev_keywords, finance_up_keywords, finance_rev_keywords) -> int:
    mydb = mysql.connector.connect(
        host="localhost",
        user="root",
        password="root",
        database="taro"
    )

    mycursor = mydb.cursor()

    sql = "INSERT INTO taro_single_card (id, en_name, ru_name, up_keywords, rev_keywords, love_up_keywords, love_rev_keywords, career_up_keywords, career_rev_keywords, finance_up_keywords, finance_rev_keywords) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
    vals = (0,
        en_name, ru_name, 
        strFromArr(up_keywords), 
        strFromArr(rev_keywords), 
        strFromArr(love_up_keywords), 
        strFromArr(love_rev_keywords),
        strFromArr(career_up_keywords),
        strFromArr(career_rev_keywords),
        strFromArr(finance_up_keywords),
        strFromArr(finance_rev_keywords)
    )
    mycursor.execute(sql, vals)
    id = mycursor.lastrowid
    mydb.commit()

    mydb.close()
    return id

def main():
    driver = uc.Chrome(headless=True, no_sandbox=True)
    driver.set_page_load_timeout(120)
    driver.get('https://labyrinthos.co/blogs/tarot-card-meanings-list')
    time.sleep(5)

    elements : List[WebElement] = []
    while True: 
        try:
            elements = driver.find_elements(By.CSS_SELECTOR, 'a.card__meta-hover')
            if len(elements) == 78:
                break
        except:
            time.sleep(1)

    print(f'Found {len(elements)} links')

    links : List[str] = []
    for element in elements:
        links.append(element.get_attribute('href'))

    for link in links:
        DriverParseLink(driver, link)

if __name__ == '__main__':
    main()