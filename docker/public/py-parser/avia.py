import undetected_chromedriver as uc
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time
import asyncio
import random

from telegram import Update
from telegram.ext import ApplicationBuilder, ContextTypes, CommandHandler

def getPrice(driver : uc.Chrome) -> str:
    elements = WebDriverWait(driver, 120).until(
        EC.presence_of_all_elements_located((By.CSS_SELECTOR, '.s__K_z9WFumQO2KSxooJM0c.s__W9yDNL_eJ6KrZBxYoreS.s__bti2LNoqGvVztixHcnni'))
    )

    if len(elements) == 0:
        print('No price elements was found')
        print('url: ' + driver.current_url)
        return '99999'

    for element in elements:
        if element.find_element(By.CSS_SELECTOR, ".s__sKkvfJDIxRicM2rUUvFJ.s__lleIiTmrq4X6cRWnmmEX > strong > span").text == 'Самый дешёвый':
            return element.find_element(By.CSS_SELECTOR, '.s__mvNEtCM6SuXfR8Kopm7T.s__pPCa7rJcciF16fYn5k_2.s__wfLcPf6IF1Ayy7uJmdtH').text
        
    return elements[0].find_element(By.CSS_SELECTOR, '.s__mvNEtCM6SuXfR8Kopm7T.s__pPCa7rJcciF16fYn5k_2.s__wfLcPf6IF1Ayy7uJmdtH').text

async def run_parser(bot): 

    actualPrice = 99999

    ids = [
        226508937,
        761891853
    ]
    link = 'https://www.aviasales.ru/search/MOW0308AER1'
    await bot.send_message(chat_id=226508937, text='Parser started')
    await bot.send_message(chat_id=761891853, text='Parser started')
    print('running selenium')
    while True:
        driver = uc.Chrome(headless=True, no_sandbox=True)
        driver.set_page_load_timeout(120)
        try:
            print('opening page')
            driver.get(link)
            print('page opened')
            WebDriverWait(driver, 120).until( 
                EC.presence_of_element_located((By.CSS_SELECTOR, '.prediction-advice__title'))
            )
            print('prices from avia companies received to aviasales')
            time.sleep(10)
            print('slept 10 seconds')
            price = getPrice(driver).replace('₽', '')
            price = price.replace(' ', '')
            print(f'Price found: {price}')
            if actualPrice > int(price):
                actualPrice = int(price)
                print('Cheaper price found!')
                for id in ids:
                    print (f'Sending message to {id}')
                    await bot.send_message(chat_id=id, text=f'Более дешевая цена на билет Москва В СОЧИИИИ. Найдена. <b>{price}₽</b>.\n Ссылка для покупки ниже!\n{link}', parse_mode='html')

            secs = random.randint(10, 60)
            millisec = random.randint(1, 1000)

            waitBefore = secs + millisec / 1000
            waitAfter = waitBefore / (random.randint(2,3))

            print(f"Wait before close: {waitBefore}")
            print(f"Wait after close: {waitAfter}")

            time.sleep(waitBefore)

            driver.close() 
            driver.quit()
            
            time.sleep(waitAfter)
        except Exception as e:
            print('Exception raised:')
            print(e)
            driver.close() 
            driver.quit()

        

async def main():
    application = ApplicationBuilder().token('6841974465:AAEfLxNrd8tMcPh3_cQ4JYqf_NJ6_oUlZ6A').build()
    asyncio.create_task(run_parser(application.bot))
    await application.bot.send_message(chat_id=226508937, text='Bot ready')
    await application.bot.send_message(chat_id=761891853, text='Bot ready')

    while True:
        await asyncio.sleep(1000)

if __name__ == '__main__':
    asyncio.run(main())