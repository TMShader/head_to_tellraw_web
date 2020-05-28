import numpy
import time
import requests
from PIL import Image
import sys
import json
from io import BytesIO


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
#     head_img.show()
    head = head_img.load()

#     head = Image.open('head.png')
#     head = head.load()

#     command = 'give @p minecraft:command_block{display:{Name:\\"{\\"text\\":\\"' + uname + \
#         '\\",\\"italic\\":false}]\\"}, BlockEntityTag: {CustomName: \\"{\\"text\\": \\"' + \
#         uname + '\\"}\\", Command: \\"tellraw @a [\\" \\"'

    command = 'tellraw @a [" "'

    full = command
    for y in range(0, 8):
        for x in range(0, 8):
            color = '#%02x%02x%02x' % head[x * 10, y * 10]
#            if x == 7 and y != 7:
#                full = full + \
#                    ',{"text":"\\u2588\\n","color":"' + color + '"}'
            if x == 7 and y == 3:
                full = full + \
                    ',{"text":"\\u2588","color":"' + \
                    color + '"},{"text":"          Made by\\\\n"}'
            elif x == 7 and y == 4:
                full = full + \
                    ',{"text":"\\u2588","color":"' + color + \
                    '"},{"text":"          ' + uname + '\\\\n"}'
            elif x == 7 and y != 7 and y != 3 and y != 4:
                full = full + ',{"text":"\\u2588","color":"' + \
                    color + '"},{"text":"\\\\n"}'
            else:
                full = full + \
                    ',{"text":"\\u2588","color":"' + color + '"}'
                # print('#%02x%02x%02x' % image[x * 10, y * 10])
                # full = full + ',{\\"text\\":\\" \\n \\"}'

    full = full + ']'

    head_img.close()

    return full


if __name__ == "__main__":
    print(generate(sys.argv[1]))
