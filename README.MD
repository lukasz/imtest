# iTech Media Tech Test

If you are reading this, you made it through our initial stage interviews - congratulations! A big thank you is also due, in taking the time to complete our technical test. This is an opportunity for you to really show off, and allows us to better understand you as a developer - that's good for everyone!

We have tried to make sure this test doesn't take more than two hours per stack to complete, so take that into account when doing your work - *this isn't enough time for perfection.* 

It's a good idea to keep notes of things you might do differently if you had more time as these will be great discussion points in the next stage of the interview process where we will code review and do some paired programming.

This boilerplate is provided as a starting point to get going quickly, but don't feel restricted by it. Tear the whole thing up and start again if that's what you want to do!

Read the instructions below *carefully* and have fun!

# Getting Started

The only requirements to get going are to have *docker* and *docker-compose* installed. No dependencies will need to be installed to your machine as these are handled inside the container itself.

You can then bring up the development environment at a terminal by typing `docker-compose up --build`.

Both containers use PHP 8 and we have configured the environment to volume mount your source code inside the container, so any code changes are reflected without needing to rebuild the containers. The exception is with composer - if you add new packages, you'll need to bring docker-compose down and re-build.

# Services

We have separated the back-end API from the front-end code, so these run on different ports.

`http://localhost:5000` should bring up the documentation for the API.

`http://localhost:3000` should bring up the front-end with a basic page.

# Back-end Task

This task is to be completed by those applying for a back-end or full stack position.

A recipes API is included in this code base that is documented on `http://localhost:5000`. There are 4 endpoints - `/recipes/raw`, `/instructions/raw`, `/ingredients/raw` and `/recipes`.

For the sake of this test, imagine that `/recipes` doesn't exist. Please create a new endpoint `/benchmark` that will work in the same way as `/recipes`, but by consuming the other 3 "raw" endpoints over HTTP, rather than from the database.

 * You can either use the provided boilerplate or create this as a stand-alone API
 * Please do not use any frameworks, for example Symfony/Laravel
 * Simple libraries such as Guzzle are welcome, but as a general rule - if you can do it without, do so.
 
# Front-end Task

This task is to be completed by those applying for a front-end or full stack position.

https://www.figma.com/file/C7kIEwEM7MzrZams5aCrdI/Full-Stack-Test-WireFrame?node-id=6878%3A434

You have been given the following design work and access to a recipes API.

Please create a responsive website following the mobile and desktop designs, allowing for recalculation of the ingredient quantities based on the required number of servings. For example, a recipe that serves 2 people using 1 egg, would require 2 eggs if calculated for 4 people.

The API is part of this codebase and once up and running, the documentation will be available on `http://localhost:5000`. You will want to use the `/recipes` endpoint and render a random recipe upon page load.

* The design is a *rough guide* and not intended to be pixel perfect.
* Please do not use any frameworks, for example React/Svelte/Vue
* Please do not use libraries such as Lodash/jQuery.
* We expect vanilla JavaScript and CSS.

# Troubleshooting & Questions

If you are having any problems getting setup, or you require further clarity on what is being asked of you, please get in touch with us and we will help. It's worth having a looking at the following FAQ though.

# FAQ

## What version of PHP can I use?

Our docker images use PHP 8. We aren't going to restrict you, but the easiest thing is to use that :)

## Why can't I install new composer packages?

You can, you just need to restart docker-compose as it installs them at build time.

## Why can't I connect to the API from my code?

Docker networking is different for every OS and in some cases, such as making requests from one container to another, you may need to use `host.docker.internal` instead of `localhost`.

## How do I get a terminal?

You can access a terminal for either service by typing `docker-compose exec back sh` or `docker-compose exec front sh`, although this shouldn't be necessary. Errors are output to the screen via docker-compose.




