# Roadmap

## Sending Delayed with Prevention
See if it is possible to send out delayed notifcations that have a continue to not be send if something happend in the mean time.
1 store class+ user + channel ? if present then not send => remove from database when triggered
2 call a determiner function to send or not send. How  to abstract and make this determiner ?
3 unittesting

## Mail Creation Extension
### Create one of mails
Ability to send a mail and enter a existing user
or select a list of users
Lastigheid hierbij is dat mails een unique mailtemplate class hebben en bij admin created mails is die class niet unique
custom mailables zijn niet unsubscribable omdat die manual zijn

### Create manual templates
Create a template / delete
Select template to send to one or more users manually
Translatables
Lastigheid hierbij is dat mails een unique mailtemplate class hebben en bij admin created mails is die class niet unique

# Resend failed mail
Warning if undelivered, offer resend what has been sent?
