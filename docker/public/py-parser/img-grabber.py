import undetected_chromedriver as uc
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import requests
import asyncio
from bs4 import BeautifulSoup as bs

async def r():
    resp = requests.get('https://labyrinthos.co/blogs/tarot-card-meanings-list')
    html = resp.text
    elements = bs(html, 'html.parser').select('a.card__meta-hover')
    hrefs = []
    for element in elements:
        hrefs.append(element.get('href'))
        print(element.get('href'))

    print('total links: ' + str(len(hrefs)))
    print('________________________________________')

    counter = 4
    for href in hrefs:
        resp = requests.get('https://labyrinthos.co' + href)
        innerHTML = resp.text
        if innerHTML:

            images = bs(innerHTML, 'html.parser').select("img.lazyarticle[data-expand]")
            image = images[len(images) - 1]

            src = image.get('data-src').removeprefix('https:').removeprefix("//")
            print('https://' + src)
            download_image('https://' + src, "cards/" + str(counter) + '.png')
            counter = counter + 1
        else:
            print('Not found for: ' + href)
    

def download_image(url, save_path):
    r = requests.get(url,stream=True)
    if r.status_code == 200:
        with open(save_path, 'wb') as f:
            for chunk in r:
                f.write(chunk)
        print(f"Картинка успешно сохранена в {save_path}")
    else:
        print(f"Не удалось скачать картинку. Код статуса: {r.status_code}")


async def main():
    await r()


if __name__ == "__main__":
    asyncio.run(main())