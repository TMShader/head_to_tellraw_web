import numpy
import time
import requests
from PIL import Image
import sys
import json
from io import BytesIO


def quantizetopalette(silf, palette, dither=False):
    """Convert an RGB or L mode image to use a given P image's palette."""
    palette = palette.convert("P", palette=Image.ADAPTIVE, colors=16)
    silf.load()

    # use palette from reference image
    palette.load()
    if palette.mode != "P":
        raise ValueError("bad mode for palette image")
    if silf.mode != "RGB" and silf.mode != "L":
        raise ValueError(
            "only RGB or L mode images can be quantized to a palette"
        )
    im = silf.im.convert("P", 1 if dither else 0, palette.im)
    # the 0 above means turn OFF dithering

    # Later versions of Pillow (4.x) rename _makeself to _new
    try:
        return silf._new(im)
    except AttributeError:
        return silf._makeself(im)


def generate(uname):
    #     with open('head.png', 'wb') as handle:
    #         uuid_raw = json.loads(requests.get(
    #             "https://api.mojang.com/users/profiles/minecraft/" + uname).text)
    #         uuid = uuid_raw["id"]
    #         response = requests.get(
    #             "https://crafatar.com/avatars/" + uuid + "?size=80&overlay")
    #
    #         if not response.ok:
    #             print(response)
    #
    #         for block in response.iter_content(1024):
    #             if not block:
    #                 break
    #             handle.write(block)

    uuid_raw = json.loads(requests.get(
        "https://api.mojang.com/users/profiles/minecraft/" + uname).text)
    uuid = uuid_raw["id"]
    response = requests.get(
        "https://crafatar.com/avatars/" + uuid + "?size=80&overlay")

    head_img = Image.open(BytesIO(response.content))
    palette = Image.open("BW.png")
    head_img = quantizetopalette(head_img, palette, dither=False)
#     head_img.show()
    head = head_img.load()

#     head = Image.open('head.png')
#     head = head.load()

    command = 'tellraw @a [" "'

    full = command
    for y in range(0, 8):
        for x in range(0, 8):
            color = head[x * 10, y * 10]
            if x == 7 and y == 3:
                if color == 0:
                    full = full + \
                        ',{"text":"\\u2588","color":"white"},{"text":"          Made by\\\\n"}'
                elif color == 1:
                    full = full + \
                        ',{"text":"\\u2588","color":"gray"},{"text":"          Made by\\\\n"}'
                elif color == 2:
                    full = full + \
                        ',{"text":"\\u2588","color":"dark_gray"},{"text":"          Made by\\\\n"}'
                elif color == 3:
                    full = full + \
                        ',{"text":"\\u2588","color":"black"},{"text":"          Made by\\\\n"}'
            elif x == 7 and y == 4:
                if color == 0:
                    full = full + \
                        ',{"text":"\\u2588","color":"white"},{"text":"          ' + \
                        uname + '\\\\n"}'
                elif color == 1:
                    full = full + \
                        ',{"text":"\\u2588","color":"gray"},{"text":"          ' + \
                        uname + '\\\\n"}'
                elif color == 2:
                    full = full + \
                        ',{"text":"\\u2588","color":"dark_gray"},{"text":"          ' + uname + '\\\\n"}'
                elif color == 3:
                    full = full + \
                        ',{"text":"\\u2588","color":"black"},{"text":"          ' + \
                        uname + '\\\\n"}'
            elif x == 7 and y != 7 and y != 3 and y != 4:
                if color == 0:
                    full = full + \
                        ',{"text":"\\u2588","color":"white"},{"text":"\\\\n"}'
                elif color == 1:
                    full = full + \
                        ',{"text":"\\u2588","color":"gray"},{"text":"\\\\n"}'
                elif color == 2:
                    full = full + \
                        ',{"text":"\\u2588","color":"dark_gray"},{"text":"\\\\n"}'
                elif color == 3:
                    full = full + \
                        ',{"text":"\\u2588","color":"black"},{"text":"\\\\n"}'
            else:
                if color == 0:
                    full = full + \
                        ',{"text":"\\u2588","color":"white"}'
                elif color == 1:
                    full = full + \
                        ',{"text":"\\u2588","color":"gray"}'
                elif color == 2:
                    full = full + \
                        ',{"text":"\\u2588","color":"dark_gray"}'
                elif color == 3:
                    full = full + \
                        ',{"text":"\\u2588","color":"black"}'
                # print('#%02x%02x%02x' % image[x * 10, y * 10])
                # full = full + ',{\\"text\\":\\" \\\\n \\"}'

    full = full + ']'

    head_img.close()

    return full


if __name__ == "__main__":
    print(generate(sys.argv[1]))
