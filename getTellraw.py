import numpy
import time
import requests
from PIL import Image
import sys
import json


def generate(uname):
    with open('head.png', 'wb') as handle:
        uuid_raw = json.loads(requests.get(
            "https://api.mojang.com/users/profiles/minecraft/" + uname).text)
        uuid = uuid_raw["id"]
        response = requests.get(
            "https://crafatar.com/avatars/" + uuid + "?size=80&overlay")

        if not response.ok:
            print(response)

        for block in response.iter_content(1024):
            if not block:
                break
            handle.write(block)

    head = Image.open('head.png')
    head = head.load()

    command = '/give @p minecraft:command_block{display:{Name:"{\\"text\\":\\"' + uname + \
        '\\",\\"italic\\":false}]"}, BlockEntityTag: {CustomName: "{\\"text\\": \\"' + \
        uname + '\\"}", Command: "tellraw @a [\\" \\"'

    full = command
    for y in range(0, 8):
        for x in range(0, 8):
            color = '#%02x%02x%02x' % head[x * 10, y * 10]
            if x == 7 and y != 7:
                full = full + \
                    ',{\\"text\\":\\"\\\\u2588\\\\n\\",\\"color\\":\\"' + color + '\\"}'
            else:
                full = full + \
                    ',{\\"text\\":\\"\\\\u2588\\",\\"color\\":\\"' + color + '\\"}'
                # print('#%02x%02x%02x' % image[x * 10, y * 10])
                # full = full + ',{\\"text\\":\\" \\n \\"}'

    full = full + ']"}}'

    return full


if __name__ == "__main__":
    print(generate(sys.argv[1]))
