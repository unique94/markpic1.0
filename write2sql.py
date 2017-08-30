#!/usr/bin/env python
# encoding: utf-8

import MySQLdb
import os
import re
import sys


def write(source_dir, desc, db):
    dirlen = 0
    cursor = db.cursor()
    reg = re.compile(r'([_\w\d]+)$')
    imgId = 0
    for rt, dirs, files in os.walk(source_dir):
        if rt == source_dir:
            continue
        rt = reg.findall(rt)[0]
        sql = 'insert into dir(dirName) values("%s")' %rt
        cursor.execute(sql)
        print rt, 'starts'
        dirlen += 1
        for pic in files:
            imgId += 1
            sql = 'insert into image(dirId, classId, imgPath, faces, source) values(%d, 0, "%s", %s, "star")' \
                  %(dirlen, desc + '/' + rt + '/' + pic, str(imgId))
            cursor.execute(sql)

            sql = 'insert into region(imgId, x, y, h, w) values(%d, %f, %f, %f, %f)' \
                  %(imgId, 0.0, 0.0, 30.0, 40.0)
            cursor.execute(sql)

        print rt, 'finish'
    db.commit()

if __name__ == "__main__":

    assert len(sys.argv) == 3, 'argv must 3'
    db = MySQLdb.connect('localhost', 'root', sys.argv[2], 'opzoonFace')
    write(sys.argv[1], 'images/photo', db)
