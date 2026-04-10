# Mizuhara

Mizuhara is our personal project we build in our free-time.
This project is about a little home automation and also there for practice.

## Overview

### Mizuhara backend (this)

The thing that glues it all together. Assisting microservice (like the stock-in/stock-out app)
talk with this very backend.
It comes with its own database and ties all core features together.
Data comes in and out primarily through the REST-Api (love goes out to API Platform <3)
Additionally, there is an admin panel included (thank you EasyCorp/EasyAdmin) for quick edits when needed.

### Mizuhara frontend

This is what we use to show up on our tablets at home. It's our interface interacting with the system.

### Barcode Scanning PWA

A small side project that aids with stocking in and out of stocks in the household.
It's a small Vue app with a camera component.



We plan to add more if we think there is more we can do to automate managing our household.
