import sys
import smtplib
from email.mime.text import MIMEText

email1 = ""
email2 = ""


#     # email3 = sys.argv[3]
    # print(email1)
# print (sys.argv[1])


subject = "Sample Subject"
body = email2
sender = "devjbellen@gmail.com"
recipients = email1
password = "mocj lrva fohb jdht"


def send_email(subject, body, sender, recipients, password):
    msg = MIMEText(body)
    msg['Subject'] = subject
    msg['From'] = sender
    msg['To'] = recipients
    with smtplib.SMTP_SSL('smtp.gmail.com', 465) as smtp_server:
       smtp_server.login(sender, password)
       smtp_server.sendmail(sender, recipients, msg.as_string())
    print("Message sent!")

if len(sys.argv) > 1 :
    email1 = sys.argv[1]
    email2 = sys.argv[2]
    send_email(subject, body, sender, recipients, password)
else:
    print("Error: 2 Argument required Usage: ./test.py <email>")
    
