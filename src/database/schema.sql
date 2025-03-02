CREATE TABLE IF NOT EXISTS bank_accounts (
   account_number INTEGER PRIMARY KEY,
   balance REAL NOT NULL
);

CREATE TABLE IF NOT EXISTS transactions (
    id TEXT PRIMARY KEY,
    payment_method TEXT NOT NULL,
    account_number INTEGER NOT NULL,
    original_amount REAL NOT NULL,
    fee_amount REAL NOT NULL,
    final_amount REAL NOT NULL,
    created_at TEXT NOT NULL,
    FOREIGN KEY (account_number) REFERENCES bank_accounts(account_number)
);
