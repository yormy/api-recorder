# bedrockusersv2 - Message Extension

![bedrockusersv2](../../assets/images/bedrockusersv2.png)

::: tip Definition
bedrockusersv2s were short-distance relay runners who delivered official messages and sometimes small parcels throughout the empire. Young men, especially those with superior running skills, were chosen for this occupation
:::

## Goal
Add many additional functionality to the messaging system to easy manage messages
- Customizable notifications in your database (emails, database notifications, slack messages)
- Translations of those messages
- Track sent out emails (content of message, user, open clickthrough)
- Users can unsubscribe from messages that you specify that are unsubscribable to

## Overview


## Features
Features that bedrockusersv2 include:

### Messaging
- Manage the content of messages that go out in your database (no need for a developer to change an email)
- Add buttons, links, tables
- Use different styles for the messages

### Tracking
- Log all emails that are going out with the userId
- Show all emails that were sent to a specific user
- Track when an email has been opened (and from what IP address and user agent) (uses tracking pixels, so not all email clients support that)
- Track when a link was clicked in the email
- Allow for a developer to encrypt privacy data (email content /ip address)
- Exclude certain emails from their content being logged (for security)

### Subscribing
- Allow a user to unsubscribe to a certain email (only for unsubscribable emails)
- Manage the channels on where to receive notifications


* Translate your emails in your backend, no need for programmers
* Customize all text in your emails by the admin, not line by line translations by programmers
* Preview emails
* Let customers subscribe/unsubscribe to those emails that you allow unsubscriptions
* Track notifications sent to customers and show them in the customer dashboard
* Send notifications easy accross multiple channels

<!--@include: ../guide/basic/frontend.md-->
