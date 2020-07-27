# CA2

An opinionated PHP clean-architecture project template. 

"If you would like to bake an apple pie from scratch you must first invent the universe"
-- Dr. Carl Sagan

## Design notes

1. All the main architectural files are bunged together in the root, so they can share resources 
like .env and so we can see everything involved at a glance at this time
1. This uses vlucas/phpdotenv to bring values from the .env or .env.test files into the PHP. 
Factories can use $_ENV superglobal to construct DB parameters, etc.
1. docker-compose slurps up .env so the values are easily injected and passed to build as args, 
no more docker-compose.override.yml needed for configuration values, only for service definitions, as it should be.
1. APP_ENV is now just a value that can be polled, it does not determine what env file is loaded.
You switch between prod and dev by putting the prod values in your .env file. 
1. The test env is a special case. It is activated by the test runner's bootstrap switching .env file to .env.test.
1. Makefile includes .env too, so the values can be used there.
1. Makefile is for operating on the non-test environment by default. To switch the environment, use e.g. 
`make db_reset_test ENV_FILE=".env.test"`
1. Makefile is for using on the host; it runs commands inside the containers, from the outside. (containers should not orchestrate)
It should be coded with production safety in mind, i.e. refuse to do destructive actions if APP_ENV is not dev.
1. Yarn (Facebook's version of npm) is used here to build CSS from SCSS with `make frontend`.

TODO:

Test runner implicit transaction wrapper.

Don't hook up XDebug for prod builds.

Doctrine DBAL, ORM, migrations, fixtures. CLI pipeline for all these. 
Then SQL repository factories etc.

 
