
async function fetchTransaction(transactionId){
    try{
        const response = await fetch(`http://localhost:3000/getTransaction`, {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
            },
                body: JSON.stringify({ transactionId }),
        });
        const data     = await response.json();
        
        console.log(data);
        displayReceipt(data);
        }   catch (error){
        console.error('Error fetching transaction:', error);
    }
}
function displayReceipt(data) {
    const receiptContainer = document.getElementById('receiptContainer');
    const receiptContent = document.getElementById('receiptContent');

    // Clear previous content
    receiptContent.innerHTML = '';

    if (data.error) {
        // Display error message
        receiptContent.innerText = `Error: ${data.error}`;
    } else if (data.transaction) {
        // Display transaction details
        const transaction = data.transaction;
        const transactionHTML = `
            <p>Sender: ${transaction.sender}</p>
            <p>Recipient: ${transaction.recipient}</p>
            <p>Amount: ${transaction.amount}</p>
            <p>Timestamp: ${transaction.timestamp}</p>
            <p>Transaction ID: ${transaction.txidString}</p>`;
        receiptContent.innerHTML = transactionHTML;
    }
}   


const transactionIdElement = document.getElementById('transactionId');
fetchTransaction(transactionIdElement.getAttribute('data-transaction-id'));