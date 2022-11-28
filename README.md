# OrangeBox | bWAPP Docker
This is a simple Docker image for the OWASP application designed to teach and demonstrate various web app vulnerabilities.

### The reason
This Docker image automates this tedious process and provides you with a click and run solution that will provide you with a bWAPP instance in a few seconds.

# Container Setup 📦
### Pull the Docker image and run :D
- This repo provides you with a prebuilt Docker image
```
docker pull s4msar4/orangebox
```

## Running the bWAPP container
```
docker run -d -p 80:80 s4msar4/orangebox
```

# Editing the container 🔬
### If you want to make your own changes to the project you can simply clone this repo and do whatever you need.
```
git clone https://github.com/Samsar4/orangebox-main && cd orangebox-main
```
## Make the changes on the repo, build and run
```
docker build -t s4msar4/orangebox .
docker run -p 80:80 -d s4msar4/orangebox
```

--- 

## Installing bWAPP 🔴
- After running the bWAPP container, navigate to http://127.0.0.1/install.php to complete the bWAPP setup process.
