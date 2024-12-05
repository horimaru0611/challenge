import face_recognition
import sys
import json

# 登録済みの顔画像（データベースから取得した顔画像）をロード
known_image = face_recognition.load_image_file("known_face.jpg")
known_encoding = face_recognition.face_encodings(known_image)[0]

# 受け取った画像をロード
unknown_image = face_recognition.load_image_file(sys.argv[1])
unknown_encoding = face_recognition.face_encodings(unknown_image)

response = {}

if len(unknown_encoding) > 0:
    unknown_encoding = unknown_encoding[0]
    results = face_recognition.compare_faces([known_encoding], unknown_encoding)
    
    if results[0]:
        response['matched'] = True
    else:
        response['matched'] = False
else:
    response['matched'] = False

# 結果を返す
print(json.dumps(response))
