# Quick CMS

# 1. How to Install Quick CMS on local Windows
1.1 Visual Studio 2012 VC
Download and install Visual Studio 2012 : VC 11 vcredist_x64 from http://www.microsoft.com/en-us/download/details.aspx?id=30679

1.2 Wampserver
Download an install latest version of Wampserver from https://www.wampserver.com/en/

1.3 Git
Download and install Git from https://git-scm.com/download/win

1.3 Checkout project
Open program Git Bash (C:\Program Files\Git\git-bash.exe). Browse to your www directory and clone the project with the following commands:
`cd C:\Users\user\wamp64\www
clone https://github.com/europa9/quick_cms.git`

1.4 Create database
Open phpMyAdmin at localhost/phpmyadmin/. Default username is root without password. Create a database named quick.

1.5 Install Quick CMS
Open http://localhost/quick_cms and follow the instructions to install the CMS.


# 2. How to fetch changes
Open Git Bash and write the following commands:
`cd C:\Users\user\wamp64\www
git pull`

# 3. How to Commit changes
Open Git Bash and write the following commands:
`cd C:\Users\user\wamp64\www
git pull
git add -A
git commit -m "description of changes"
git push`


