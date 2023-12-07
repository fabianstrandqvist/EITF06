
const SHA256 = require('crypto-js/sha256');
const EC = require('elliptic').ec;

const ec = new EC('secp256k1');

class Transaction {
    constructor(sender, amount){
        this.sender     = sender;
        this.recipient  = '3fd30542fe3f61b14bd4a4b2dc0b6fb30fa6f63ebce52dd1778aaa8c4dc02cff';
        this.amount     = amount;
        this.timestamp  = new Date();
        this.txid       = SHA256(SHA256(this.sender + this.recipient + this.amount + this.timestamp));
        this.txidString = this.txid.toString();
    }

    calculateHash(){
        return SHA256(this.sender + this.recipient + 
            this.amount + this.timestamp);
    }

    signTransaction(signingKey) {
        const key         = ec.keyFromPrivate(signingKey, 'hex'); // Load private key
        const hash        = this.calculateHash();
        const hashBuffer  = Buffer.from(hash.toString(), 'hex');
        const signature   = key.sign(hashBuffer);
        this.signature    = signature.toDER('hex');
    }

    isValid(){
        if (!this.signature || this.signature === ''){
            return false;
        }
        
        const publicKey = ec.keyFromPublic(this.sender, 'hex');
        return publicKey.verify(this.calculateHash(), this.signature);
    }
} 

class Block{
    constructor(index, timestamp, data, transaction_id, previousHash=''){
       this.index          = index;
       this.timestamp      = new Date(timestamp).toUTCString();
       this.data           = data;
       this.transaction_id = transaction_id;
       this.previousHash   = previousHash;
       this.hash           = this.calculateHash(); 
       this.nonce          = 0;
    }

    calculateHash(){
        return SHA256(this.index + this.previousHash + 
        this.nonce + this.timestamp + JSON.stringify(this.data)).toString();
    }

    mineBlock(difficulty){
        while(this.hash.substring(0, difficulty) !== Array(difficulty + 1).join("0")){
            this.nonce++;
            this.hash = this.calculateHash();
        }

        console.log("Block mined: " + this.hash);
    }
}


class Blockchain{
    constructor(){
        this.chain      = [this.createGenesisBlock()];
        this.difficulty = 3;
    }

    createGenesisBlock(){
        return new Block(0, "01/01/2023", "Genesis block", "0");
    }

    getLatestBlock(){
        return this.chain[this.chain.length - 1];
    }

    getBlockByTransactionId(transaction_id){
        for(const block of this.chain){
            if(block.transaction_id === transaction_id){
                return block;
            }
        }
        return null;
    }

    addBlock(newBlock){
        newBlock.previousHash = this.getLatestBlock().hash;
        newBlock.mineBlock(this.difficulty);
        this.chain.push(newBlock);
    }

    isChainValid(){
        for(let i = 1; i < this.chain.length; i++){
            const currentBlock  = this.chain[i];
            const previousBlock = this.chain[i - 1];

            if(currentBlock.hash != currentBlock.calculateHash()){
                return false;
            }

            if(currentBlock.previousHash !== previousBlock.hash){
                return false;
            }
        }
        return true;
    }
}

const express    = require('express');
const cors       = require('cors');
const bodyParser = require('body-parser');

const app  = express();
const port = 3000;

app.use(bodyParser.json(), cors());

const blockchain = new Blockchain();

let index = 1;

app.post('/addTransaction', (req, res) => {
    const { sender, amount, privateKey } = req.body;

    const transaction = new Transaction(sender, amount, Buffer.from(privateKey, 'hex'));
    transaction.signTransaction(privateKey);

    const newBlock    = new Block(index, Date.now(), JSON.stringify(transaction), transaction.txid.toString());
    blockchain.addBlock(newBlock);
    index++;
    console.log(blockchain);

    res.json({
        transactionMessage: 'Transaction added to the blockchain.',
        blockMinedMessage: 'Block mined.'
    });
});

app.all('/getTransaction', (req, res) =>{
    const {transactionId} = req.body;
    const block           = blockchain.getBlockByTransactionId(transactionId);

    if (block) {
        res.json({
            transaction: JSON.parse(block.data)
        });
    } else {
        res.status(404).json({
            error: 'Transaction not found.'
        });
    }
    
})
app.listen(port, () => {
    console.log(`Blockchain server listening at http://localhost:${port}`);
  });

