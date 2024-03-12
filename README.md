# dehos-app
dehos-app

____
Create symfony Project
- composer create-project symfony/website-skeleton dehos
1. ./bin/console make:entity Product
2.  Next: When you're ready, create a migration with 
    => php bin/console make:migration
3.  Then: Run the migration with 
    => php bin/console doctrine:migrations:migrate

____
Vider le cache
Executing script : 
    => php bin/console cache:clear
Executing script :
    => php bin/console assets:install
    => php bin/console assets:install public
    
____
Hash password in symfony console by running command :
    => php bin/console security:hash-password

____
Make repo on project

1. Create a new repo in github site


2. On porject on the machine. Create a repo and link it whit remote repo
- …or create a new repository on the command line

- echo "# dehos" >> README.md
- git init
- git add README.md
- git commit -m "first commit"
- git branch -M main
- git remote add origin https://github.com/gfmilingui/dehos.git
- git push -u origin main

2(bis). On project with already repo. Link to remote repo
- …or push an existing repository from the command line

- git remote add origin https://github.com/gfmilingui/dehos.git
- git branch -M main
- git push -u origin main


