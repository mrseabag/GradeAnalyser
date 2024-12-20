// Load the MySQL module
const mysql = require('mysql');

// Load the fs module to read the SSL certificates
const fs = require('fs');

// Read the SSL certificates
const ssl = {
  key: fs.readFileSync('/path/to/ssl/key.pem'),
  cert: fs.readFileSync('/path/to/ssl/cert.pem'),
  ca: fs.readFileSync('/path/to/ssl/ca.pem')
};

// Create a connection pool to the MySQL server with SSL encryption
const pool = mysql.createPool({
  connectionLimit: 10,
  host: 'localhost', // Bind the MySQL server to the local IP address only
  user: 'root',
  password: '',
  database: 'database123',
  ssl: ssl
});

// Define a function to execute SQL queries
function executeQuery(query, params, callback) {
  pool.getConnection(function(err, connection) {
    if (err) {
      callback(err);
      return;
    }
    connection.query(query, params, function(err, results) {
      connection.release();
      if (err) {
        callback(err);
        return;
      }
      callback(null, results);
    });
  });
}
