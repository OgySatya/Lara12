// Get the username from command line arguments
const username = process.argv[2];

if (!username) {
    console.log('Please provide a username!');
} else {
    console.log(`Hello, ${username}!`);
}
