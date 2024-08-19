import requests
import json
from bs4 import BeautifulSoup
import mysql.connector
from datetime import datetime

signs = [
    {
        "id": 5,
        "name": 'Лев',
        "targets": [
            {
                "link": 'https://7days.ru/astro/horoscope/leo/today',
                "selector": '#col1 > div.horoscope-7days > div.horoscope-7days__znak-zodiac > div.horoscope-7days__content > div.horoscope-7days__content_text'
            },
            {
                "link": 'https://global38.ru/horoscope/today/1',
                'selector': '.horoscope_text'
            },
            {
                "link": 'https://www.thevoicemag.ru/horoscope/daily/leo/',
                'selector': '.sign__description-text'
            }
            ,
            {
                "link": 'https://horoscopes.rambler.ru/leo',
                'selector': '[itemprop=articleBody]'
            }
        ]
    },
    {
        "id": 6,
        "name": 'Дева',
        "targets": [
            {
                "link": 'https://7days.ru/astro/horoscope/virgo/today',
                "selector": '#col1 > div.horoscope-7days > div.horoscope-7days__znak-zodiac > div.horoscope-7days__content > div.horoscope-7days__content_text'
            },
            {
                "link": 'https://global38.ru/horoscope/today/2',
                'selector': '.horoscope_text'
            },
            {
                "link": 'https://www.thevoicemag.ru/horoscope/daily/virgo/',
                'selector': '.sign__description-text'
            }
            ,
            {
                "link": 'https://horoscopes.rambler.ru/virgo',
                'selector': '[itemprop=articleBody]'
            }
        ]
    },
    {
        "id": 1,
        "name": 'Овен',
        "targets": [
            {
                "link": 'https://7days.ru/astro/horoscope/aries/today',
                "selector": '#col1 > div.horoscope-7days > div.horoscope-7days__znak-zodiac > div.horoscope-7days__content > div.horoscope-7days__content_text'
            },
            {
                "link": 'https://global38.ru/horoscope/today/3',
                'selector': '.horoscope_text'
            },
            {
                "link": 'https://www.thevoicemag.ru/horoscope/daily/aries/',
                'selector': '.sign__description-text'
            }
            ,
            {
                "link": 'https://horoscopes.rambler.ru/aries',
                'selector': '[itemprop=articleBody]'
            }
        ]
    },
    {
        "id": 8,
        "name": 'Скорпион',
        "targets": [
            {
                "link": 'https://7days.ru/astro/horoscope/scorpio/today',
                "selector": '#col1 > div.horoscope-7days > div.horoscope-7days__znak-zodiac > div.horoscope-7days__content > div.horoscope-7days__content_text'
            },
            {
                "link": 'https://global38.ru/horoscope/today/4',
                'selector': '.horoscope_text'
            },
            {
                "link": 'https://www.thevoicemag.ru/horoscope/daily/scorpio/',
                'selector': '.sign__description-text'
            }
            ,
            {
                "link": 'https://horoscopes.rambler.ru/scorpio',
                'selector': '[itemprop=articleBody]'
            }
        ]
    },
    {
        "id": 2,
        "name": 'Телец',
        "targets": [
            {
                "link": 'https://7days.ru/astro/horoscope/taurus/today',
                "selector": '#col1 > div.horoscope-7days > div.horoscope-7days__znak-zodiac > div.horoscope-7days__content > div.horoscope-7days__content_text'
            },
            {
                "link": 'https://global38.ru/horoscope/today/5',
                'selector': '.horoscope_text'
            },
            {
                "link": 'https://www.thevoicemag.ru/horoscope/daily/taurus/',
                'selector': '.sign__description-text'
            }
            ,
            {
                "link": 'https://horoscopes.rambler.ru/taurus',
                'selector': '[itemprop=articleBody]'
            }
        ]
    },
    {
        "id": 7,
        "name": 'Весы',
        "targets": [
            {
                "link": 'https://7days.ru/astro/horoscope/libra/today',
                "selector": '#col1 > div.horoscope-7days > div.horoscope-7days__znak-zodiac > div.horoscope-7days__content > div.horoscope-7days__content_text'
            },
            {
                "link": 'https://global38.ru/horoscope/today/6',
                'selector': '.horoscope_text'
            },
            {
                "link": 'https://www.thevoicemag.ru/horoscope/daily/libra/',
                'selector': '.sign__description-text'
            }
            ,
            {
                "link": 'https://horoscopes.rambler.ru/libra',
                'selector': '[itemprop=articleBody]'
            }
        ]
    },
    {
        "id": 3,
        "name": 'Близнецы',
        "targets": [
            {
                "link": 'https://7days.ru/astro/horoscope/gemini/today',
                "selector": '#col1 > div.horoscope-7days > div.horoscope-7days__znak-zodiac > div.horoscope-7days__content > div.horoscope-7days__content_text'
            },
            {
                "link": 'https://global38.ru/horoscope/today/7',
                'selector': '.horoscope_text'
            },
            {
                "link": 'https://www.thevoicemag.ru/horoscope/daily/gemini/',
                'selector': '.sign__description-text'
            }
            ,
            {
                "link": 'https://horoscopes.rambler.ru/gemini',
                'selector': '[itemprop=articleBody]'
            }
        ]
    },
    {
        "id": 4,
        "name": 'Рак',
        "targets": [
            {
                "link": 'https://7days.ru/astro/horoscope/cancer/today',
                "selector": '#col1 > div.horoscope-7days > div.horoscope-7days__znak-zodiac > div.horoscope-7days__content > div.horoscope-7days__content_text'
            },
            {
                "link": 'https://global38.ru/horoscope/today/8',
                'selector': '.horoscope_text'
            },
            {
                "link": 'https://www.thevoicemag.ru/horoscope/daily/cancer/',
                'selector': '.sign__description-text'
            }
            ,
            {
                "link": 'https://horoscopes.rambler.ru/cancer',
                'selector': '[itemprop=articleBody]'
            }
        ]
    },
    {
        "id": 10,
        "name": 'Козерог',
        "targets": [
            {
                "link": 'https://7days.ru/astro/horoscope/capricorn/today',
                "selector": '#col1 > div.horoscope-7days > div.horoscope-7days__znak-zodiac > div.horoscope-7days__content > div.horoscope-7days__content_text'
            },
            {
                "link": 'https://global38.ru/horoscope/today/9',
                'selector': '.horoscope_text'
            },
            {
                "link": 'https://www.thevoicemag.ru/horoscope/daily/capricorn/',
                'selector': '.sign__description-text'
            }
            ,
            {
                "link": 'https://horoscopes.rambler.ru/capricorn',
                'selector': '[itemprop=articleBody]'
            }
        ]
    },
    {
        "id": 11,
        "name": 'Водолей',
        "targets": [
            {
                "link": 'https://7days.ru/astro/horoscope/aquarius/today',
                "selector": '#col1 > div.horoscope-7days > div.horoscope-7days__znak-zodiac > div.horoscope-7days__content > div.horoscope-7days__content_text'
            },
            {
                "link": 'https://global38.ru/horoscope/today/10',
                'selector': '.horoscope_text'
            },
            {
                "link": 'https://www.thevoicemag.ru/horoscope/daily/aquarius/',
                'selector': '.sign__description-text'
            }
            ,
            {
                "link": 'https://horoscopes.rambler.ru/aquarius',
                'selector': '[itemprop=articleBody]'
            }
        ]
    },
    {
        "id": 12,
        "name": 'Рыбы',
        "targets": [
            {
                "link": 'https://7days.ru/astro/horoscope/pisces/today',
                "selector": '#col1 > div.horoscope-7days > div.horoscope-7days__znak-zodiac > div.horoscope-7days__content > div.horoscope-7days__content_text'
            },
            {
                "link": 'https://global38.ru/horoscope/today/11',
                'selector': '.horoscope_text'
            },
            {
                "link": 'https://www.thevoicemag.ru/horoscope/daily/pisces/',
                'selector': '.sign__description-text'
            }
            ,
            {
                "link": 'https://horoscopes.rambler.ru/pisces',
                'selector': '[itemprop=articleBody]'
            }
        ]
    },
    {
        "id": 9,
        "name": 'Стрелец',
        "targets": [
            {
                "link": 'https://7days.ru/astro/horoscope/sagittarius/today',
                "selector": '#col1 > div.horoscope-7days > div.horoscope-7days__znak-zodiac > div.horoscope-7days__content > div.horoscope-7days__content_text'
            },
            {
                "link": 'https://global38.ru/horoscope/today/12',
                'selector': '.horoscope_text'
            },
            {
                "link": 'https://www.thevoicemag.ru/horoscope/daily/sagittarius/',
                'selector': '.sign__description-text'
            }
            ,
            {
                "link": 'https://horoscopes.rambler.ru/sagittarius',
                'selector': '[itemprop=articleBody]'
            }
        ]
    }
]


def GetPrompt(signInfo, method = "GET"):
    prompt = 'Обобщи информацию в гороскопах ниже, перепиши ее своими словами, но так, чтобы не терять смысла. Твоя задача - из нескольких гороскопов ниже написать один цельный гороскоп, который будет интереснен для читателя.'
    prompt += "\n\rГороскоп требуется для знака зодиака " + signInfo["name"] + "!\n\r"

    # TODO: remove prints
    print(signInfo["name"])
    counter = 0
    for target in signInfo["targets"]:
        counter += 1
        html = requests.request(method=method, url=target["link"], headers={'Content-Type': 'text/html'}).text
        soup = BeautifulSoup(html, 'lxml')
        prompt += "Гороскоп № " + str(counter) + ":\n\r"
        receivedHoroscope = soup.select_one(target["selector"]).text.strip()
        if len(receivedHoroscope) > 100:
            print("+" + str(counter))
            prompt += receivedHoroscope
        else:
            print("ERROR: " + str(counter))
        prompt += "\n\r"

    return prompt

def SaveDialyHoroscope(id: int, text: str):
    mydb = mysql.connector.connect(
        host="localhost",
        user="root",
        password="root",
        database="taro"
    )
    mycursor = mydb.cursor()

    html_value = text.replace('\n\n', ' ').replace('\n', ' ').replace('  ', ' ').replace('  ', ' ')
    print('Added horoscope with length: ' + str(len(html_value)))
    
    sql = "INSERT INTO horoscope (id, sign_id, hdate, period, html_tag, html_value, on_page_idx) VALUES (%s,%s,%s,%s,%s,%s,%s)"
    val = (0, id, datetime.now().strftime("%Y-%m-%d"), 1, 'p', html_value, 1)

    mycursor.execute(sql, val)
    mydb.commit()
    
    mydb.close()

def main():

    api_key = 'AQVN1KCLuEcQPTxEaPz-6M-WcLszcWn0aztsH_cv'
    url = "https://llm.api.cloud.yandex.net/foundationModels/v1/completion"

    for sign in signs:
        prompt = GetPrompt(sign, "GET")
        payload = {
            "modelUri": "gpt://b1gs47nk3voluk1k7tm2/yandexgpt/latest",
            "completionOptions": {
                "stream": False,
                "temperature": 0.4
            },
            "messages": [
                {
                    "role": "system",
                    "text": "Ты - Высококлассный астролог, истории которого людям интересны. А еще ты умеешь писать гороскопы, которые оптимизированы для поисковых систем и интересны пользователям. Не используй разметку Markdown!"
                },
                {
                    "role": "user",
                    "text": prompt + "\n\rНе пиши, что прогнозы не являются научнодоказанной информацией!\n\rНе используй разметку Markdown!"
                }
            ]
        }

        payload = json.dumps(payload)
        # Заголовки запроса
        headers = {
            'Content-Type': 'application/json',
            'Authorization': f'Api-Key {api_key}'
        }

        response = requests.post(url, headers=headers, data=payload)

        horoscope = response.json()['result']['alternatives'][0]['message']['text']
        SaveDialyHoroscope(sign['id'], horoscope)

if __name__ == "__main__":
    main()