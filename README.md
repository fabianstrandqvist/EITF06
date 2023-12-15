# EITF06

#blockchain.js

1. Start by opening a terminal and run the blockchain.js file, using node:

  'node blockchain.js'

  The blockchain will now be listening on port 3000.

2. Open a separate terminal, here you will send your transactions to the blockchain.

  To send transactions (on MacOS) to the blockchain you would use: 

  'curl -X POST -H "Content-Type: application/json" -d '{"sender":"aed106ae7fd3dbec3943418b1f7537d76b4f066ec7930056769a71999923412c", "amount":100, "privateKey":"-----BEGIN EC PRIVATE KEY----- MHQCAQEEIPQUkZgiAQmTFZadXXDqFgwWPKhbzt8NQqg3Zg27QH0coAcGBSuBBAAK   oUQDQgAEDDsUwv89FMzsP0C64kfWeF6iQis4rLP+OzuoQBfmOc5Xh/zl0jmb+dSF Eiwh0cwGQtTeIkiRHho2pUqppheAvw== -----END EC PRIVATE KEY-----"}' http://localhost:3000/addTransaction'

  You can specify your wallet (sender), amount, and your private key yourself.
