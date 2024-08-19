from typing import List
import undetected_chromedriver as uc
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.remote.webelement import WebElement
from selenium.webdriver.remote.webdriver import WebDriver
import mysql.connector

import time

# Знаки зодиака
signs = [
    'Овен', 'Телец', 'Близнецы', 'Рак', 'Лев', 'Дева', 'Весы', 'Скорпион', 'Стрелец', 'Козерог', 'Водолей', 'Рыбы'
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

def main():
    driver = uc.Chrome(headless=False, no_sandbox=True)
    driver.set_page_load_timeout(120)
    driver.get('https://chat.deepseek.com/sign_in')
    input()
    for i in range(12): 
        # read input from console
        for j in range(12-i): 
            j = j + i

            baseSign = signs[i]
            withSign = signs[j]

            print(f'{baseSign} with {withSign}')
            response = SendRequest(driver, [
                f'Напиши любовную совместимость, интересно, общими словами между {baseSign} и {withSign},  уложись в длину текста 4096 символов, можешь и меньше. Ориентируйся на эти примеры, но вступление и завершение постарайся немного изменять, чтобы не быть однотипным, вот примеры:',
                '1.Любовная совместимость между двумя Овнами — это встреча двух огненных энергий, которые могут либо слиться в мощном пламени, либо разгореться в бурном конфликте. Овны, как представители первого знака зодиака, известны своей энергией, решительностью и стремлением к лидерству. В отношениях между двумя Овнами эти качества могут создать динамичную и яркую пару, где каждый партнер поддерживает и вдохновляет другого. Овны любят быть в центре внимания и часто проявляют инициативу в любви и романтике. Когда два Овна встречаются, их отношения могут быть похожи на взрыв эмоций и страсти. Они оба стремятся к новым приключениям и не боятся рисковать, что может создать бурную и захватывающую атмосферу в их совместной жизни. Однако, такой союз также не лишен сложностей. Овны могут быть чрезмерно независимыми и агрессивными, что может привести к конфликтам и ссорам. Им нужно научиться находить баланс между своим стремлением к лидерству и потребностью в партнерстве. Важно, чтобы оба Овна учились слушать друг друга и находить компромиссы, чтобы их отношения оставались яркими и удовлетворительными. В конечном итоге, любовные отношения между двумя Овнами могут стать примером того, как две сильные личности могут сосуществовать и дополнять друг друга. Если они смогут преодолеть свои различия и научиться ценить сильные стороны друг друга, их союз может стать исключительно гармоничным и долговечным.',
                '2.Любовная совместимость между Овном и Тельцом — это тандем двух противоположностей, которые, тем не менее, могут создать гармоничную и прочную пару. Овен, символ огня и инициативы, с его бурной энергией и стремлением к новым приключениям, встречается с Тельцом, символом земли и стабильности, с его устойчивым и практичным подходом к жизни. В отношениях Овен может быть источником вдохновения и движущей силы, постоянно предлагая новые идеи и планы. Телец, в свою очередь, обеспечивает стабильность и уверенность, помогая Овну реализовать его амбиции. Это сочетание может создать баланс, где Овен учит Тельца быть более открытым к изменениям и экспериментам, а Телец учит Овна ценить устойчивость и глубину отношений. Однако, как и в любой паре, здесь могут возникнуть трудности. Овен может считать Тельца слишком медлительным и консервативным, в то время как Телец может видеть Овна как слишком импульсивного и непредсказуемого. Чтобы отношения процветали, оба партнера должны учиться слушать друг друга, уважать различия и находить компромиссы. В конечном итоге, любовные отношения между Овном и Тельцом могут стать примером того, как противоположности притягиваются и дополняют друг друга. Если они смогут преодолеть свои различия и научиться ценить сильные стороны друг друга, их союз может стать исключительно гармоничным и долговечным.'
            ])
            db = OpenConnection()
            idx = SaveRows(db, i+1, j+1, response)
            CloseConnection(db)
            response = SendRequest(driver, [
                f'Напиши интересные для читателя тексты, на приведенные подтемы по любовной совместимости, умести каждый раздел в 4096 символов, но можно и меньше, главная цель - интересная подтема и такая, чтобы человек поверил в нее: 1.Сексуальная совместимость 2.Эмоциональная совместимость 3.Интеллектуальная совместимость 4.Семейная совместимость 5.Совместимость в дружеских отношениях Если его знак {baseSign}, а знак противоположного пола {withSign}'
            ])
            db = OpenConnection()
            SaveRows(db, i+1, j+1, response, idx)
            CloseConnection(db)
    
if __name__ == "__main__":
    main()