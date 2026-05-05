# EITF06: Web Shop Under Attack

Web-based shopping demo with a PHP storefront, login and cart flow, checkout and receipt pages, and a Node.js blockchain service for recording transactions.

## Overview
This repository demonstrates a security-focused e-commerce system built with PHP, JavaScript, and Node.js. It includes product browsing, cart management, payment/receipt handling, and a custom blockchain server that stores signed transactions and exposes them to the receipt page. The project also explores common web attack surfaces and defenses such as session handling, CSRF tokens, input sanitization, and transaction logging.

## Project report
- [EITF06 Project Report PDF](https://drive.google.com/file/d/1-kXlotUM2bsS-DlQBQGMGt8TuV_Pvf12/view?usp=sharing) — project writeup covering the web shop, security considerations, and blockchain-based receipt flow.

## What’s included
- `index.php` — home page for the web shop.
- `products.php` — product listing and shopping cart management.
- `cart.php` — cart-related page logic.
- `checkout.php` and `payment.php` — checkout and payment flow.
- `receipt.php` and `receipt.js` — receipt page and blockchain transaction lookup.
- `login1.php`, `signup1.php`, `logout1.php`, and `startsession.php` — authentication and session handling.
- `blockchain.js` — Node.js blockchain server for adding and retrieving transactions.
- `transaction.js` — client-side helper for fetching transaction data.
- `connection1.php`, `functions1.php`, and `test.php` — database and shared PHP helpers.
- `images/` — storefront assets.
- `commonpasswords.txt` — password blacklist data.
- `styles.css` and `log_sign.css` — site styling.

## Quick start
1. Start the blockchain server:

   `node blockchain.js`

2. The server listens on port 3000 and accepts transaction requests at `/addTransaction`.

## Notes
- The PHP storefront expects a local PHP/MySQL environment.
- The blockchain service is used by the receipt flow to display transaction details after checkout.


