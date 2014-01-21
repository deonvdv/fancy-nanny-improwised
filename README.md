# Fancy Nanny

## Introduction

Fancy Nanny is an online service for parents to better manage their household, including their staff, like nanny's. Modern families lead very busy lives and need all the help they can get to manage it all.

With Fancy Nanny, parents have a way to easily communicate with their household members (parents, children and staff). They can easily plan meals and create shopping lists. Staff can easily view emergency contact information and tasks and events for a specific day or dates. Staff can also easily see dietary requirements and allergies for the household members.

```
**Framework:** Laravel 4.0
**Database:** MySQL
**ID:** UUID4 - see: https://github.com/ramsey/uuid.
**CDN:** Phase 2: pictures stored on CDN / CloudFiles / Amazon S3 / etc
**Phase 1:** Json API
**Phase 2:** Front-end
**Phase 3:** Billing/Subscriptions
```

## Routes: 

+ /{controllers} - all app routes - login protected
+ /api/{version}/ - all api routes (json, basic auth)

