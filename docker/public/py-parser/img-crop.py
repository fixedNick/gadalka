from PIL import Image, ImageColor,ImageMode

def cropImage(path, name):
    savePath = "cropped/" + name

    image = Image.open(path)
    x1, y1 = 209, 391  # Начальные координаты
    x2, y2 = 405, 721  # Конечные координаты

    width = x2 - x1
    height = y2 - y1
    crop = image.crop((x1,y1,x2,y2))

    for x in range(10):
        for y in range(10):
            crop.putpixel((x,y), ImageColor.getrgb("#292B3F"))
            crop.putpixel((width - 10 + x,y), ImageColor.getrgb("#292B3F"))
            crop.putpixel((x,height - 10 + y), ImageColor.getrgb("#292B3F"))
            crop.putpixel((width - 10 + x,height - 10 + y), ImageColor.getrgb("#292B3F"))

    crop.save(savePath)
    print('saved ' + savePath)


def main():


    counter = 4
    while counter <= 81:
        cropImage("cards/" + str(counter) + ".png", str(counter) + ".png")
        counter += 1

if __name__ == "__main__":
    main()