@echo off
set config_file=vars.txt
set workdir="%cd%"
set mode=1
set backup=.
set safe_mode=1

:loadconfig
title L2Web installer - Reading configuration from file...
cls
if not exist %config_file% goto configure
ren %config_file% vars.bat
call vars.bat
ren vars.bat %config_file%
call :colors 17
echo It seems to be the first time you run this version of
echo database_installer but I found a settings file already.
echo I'll hopefully ask this questions just once.
echo.
echo Configuration upgrade options:
echo.
echo (1) Import and continue: I'll read your old settings and
echo    continue execution, but since no new settings will be
echo    saved, you'll see this menu again next time.
echo.
echo (2) Import and configure: This tool has some new available
echo    options, you choose the values that fit your needs
echo    using former settings as a base.
echo.
echo (3) View saved settings: See the contents of the config 
echo    file.
echo.
echo (4) Quit: Did you came here by mistake?
echo.
set /P mode="Type a number, press Enter (default is '%mode%'): "
if %mode%==1 goto web
if %mode%==2 goto configure
if %mode%==3 (cls&type %config_file%&pause&goto loadconfig)
if %mode%==4 goto end
goto loadconfig

:colors
if /i "%cmode%"=="n" (
if not "%1"=="17" (	color F	) else ( color )
) else ( color %1 )
goto :eof

:configure
call :colors 17
title L2JWeb installer - Setup
cls
set config_version=2
set fresh_setup=1
set mysqlBinPath=%ProgramFiles%\MySQL\MySQL Server 5.1\bin
set user=root
set pass=
set db=l2web
set host=localhost
set backup=.
set logdir=.
set mysqlPath=%mysqlBinPath%\mysql.exe
echo New settings will be created for this tool to run in
echo your computer, so I need to ask you some questions.
echo.
echo 1-MySql Binaries
echo --------------------
echo In order to perform my tasks, I need the path for commands
echo such as 'mysql' and 'mysqldump'. Both executables are
echo usually stored in the same place.
echo.
if "%mysqlBinPath%" == "" (
set mysqlBinPath=use path
echo I can't determine if the binaries are available with your
echo default settings.
) else (
echo I can try to find out if the current setting actually works...
echo.
echo %mysqlPath%
)
if not "%mysqlBinPath%" == "use path" call :binaryfind
echo.
path|find "MySQL">NUL
if %errorlevel% == 0 (
echo I found MySQL is in your PATH, this will be used by default.
echo If you want to use something different, change 'use path' for 
echo something else.
set mysqlBinPath=use path
) else (
echo Look, I can't find "MYSQL" in your PATH environment variable.
echo It would be good if you go and find out where "mysql.exe" and 
echo "mysqldump.exe" are.
echo.
echo If you have no idea about the meaning of words such as MYSQL
echo or PATH, you'd better close this window, and consider googling
echo and reading about it. Setup and host an L2J webpage requires a
echo minimum of technical skills.
)
echo.
echo Write the path to your MySQL binaries (no trailing slash needed):
set /P mysqlBinPath="(default %mysqlBinPath%): "
cls
echo.
echo 2-DataBase settings
echo --------------------
echo I will connect to the MySQL server you specify, and setup a
echo Loginserver database there, most people use a single MySQL
echo server and database for both Login and Gameserver tables.
echo.
set /P user="MySQL Username (default is '%user%'): "
set /P pass="Password (will be shown as you type, default '%pass%'): "
set /P db="Database (default is '%db%'): "
set /P host="Host (default is '%host%'): "
echo.
cls

echo 3-Misc. settings
echo --------------------
set /P backup="Path for your backups (default '%backup%'): "
set /P logdir="Path for your logs (default '%logdir%'): "
:safe1
set safemode=y
set /P safemode="Debugging messages and increase verbosity a lil bit (y/n, default '%safemode%'): "
if /i %safemode%==y (set safe_mode=1&goto safe2)
if /i %safemode%==n (set safe_mode=0&goto safe2)
goto safe1
:safe2
echo.
if "%mysqlBinPath%" == "use path" (
set mysqlBinPath=
set mysqldumpPath=mysqldump
set mysqlPath=mysql
) else (
set mysqldumpPath=%mysqlBinPath%\mysqldump.exe
set mysqlPath=%mysqlBinPath%\mysql.exe
)
echo @echo off > %config_file%
echo set config_version=%config_version% >> %config_file%
echo set cmode=%cmode%>> %config_file%
echo set safe_mode=%safe_mode% >> %config_file%
echo set mysqlPath=%mysqlPath%>> %config_file%
echo set mysqlBinPath=%mysqlBinPath%>> %config_file%
echo set mysqldumpPath=%mysqldumpPath%>> %config_file%
echo set user=%user%>> %config_file%
echo set pass=%pass%>> %config_file%
echo set db=%db%>> %config_file%
echo set host=%host% >> %config_file%
echo.
echo press any key to continue...
pause> nul
goto loadconfig

:web
cls
call :colors 17
set cmdline=
set stage=1
title L2Web installer - Web database setup
echo.
echo Trying to make a backup of your web database.
set cmdline="%mysqldumpPath%" --add-drop-table -h %host% -u %user% --password=%pass% %db% ^> "%backup%\web_backup.sql" 2^> NUL
%cmdline%
if %ERRORLEVEL% == 0 goto dbok
REM if %safe_mode% == 1 goto omfg
:err1
call :colors 47
title L2Web installer - Web database setup ERROR!!!
cls
echo.
echo Backup attempt failed! A possible reason for this to 
echo happen, is that your DB doesn't exist yet or your
echo setting are invalid. I could try to create %db% for you.
echo.
:ask1
set dbprompt=y
echo ATTEMPT TO CREATE WEB DATABASE:
echo.
echo (y)es
echo.
echo (n)o
echo.
echo (r)econfigure
echo.
echo (q)uit
echo.
set /p dbprompt= Choose (default yes):
if /i %dbprompt%==y goto dbcreate
if /i %dbprompt%==n goto end
if /i %dbprompt%==r goto configure
if /i %dbprompt%==q goto end
goto ask1

:omfg
cls
call :colors 57
title L2Web installer - potential PICNIC detected at stage %stage%
echo.
echo There was some problem while executing:
echo.
echo "%cmdline%"
echo.
echo I'd suggest you to look for correct values and try this
echo script again later. But maybe you'd prefer to go on now.
echo.
:omfgask1
set omfgprompt=q
echo (c)ontinue running the script
echo.
echo (r)econfigure
echo.
echo (q)uit now
echo.
set /p omfgprompt= Choose (default quit):
if  /i %omfgprompt%==c goto %label%
if  /i %omfgprompt%==r goto configure
if  /i %omfgprompt%==q goto horrible_end
goto omfgask1

:dbcreate
call :colors 17
set cmdline=
title L2Web installer - Web database setup - DB Creation
echo.
echo Trying to create a Webr database...
set cmdline="%mysqlPath%" -h %host% -u %user% --password=%pass% -e "CREATE DATABASE %db%" 2^> NUL
%cmdline%
if %ERRORLEVEL% == 0 goto webinstall
if %safe_mode% == 1 goto omfg
:err2
call :colors 47
title L2Web installer - Web database setup - DB Creation error
cls
echo An error occured while trying to create a database for 
echo your web.
echo.
echo Possible reasons:
echo 1-You provided innacurate info , check user, password, etc.
echo 2-User %user% don't have enough privileges for 
echo database creation. Check your MySQL privileges.
echo 3-Database exists already...?
echo.
echo Unless you're sure that the pending actions of this tool 
echo could work, i'd suggest you to look for correct values
echo and try this script again later.
echo.
:ask2
set omfgprompt=q
echo (c)ontinue running
echo.
echo (r)econfigure
echo.
echo (q)uit now
echo.
set /p omfgprompt= Choose (default quit):
if /i %omfgprompt%==c goto loadconfig
if /i %omfgprompt%==q goto end
if /i %omfgprompt%==r goto configure
goto ask2

:dbok
call :colors 17
title L2Web installer - Web database setup - WARNING!!!
echo.
:asklogin
echo WEB DATABASE install type:
echo.
echo (f)ull: I will destroy data in your `gameserver` tables.
echo.
echo (r)econfigure: You'll be able to redefine MySQL path,
echo    user and database information and start over with
echo    those fresh values.
echo.
echo (q)uit
echo.
set /p prompt= Choose (%msg%) : 
if /i %prompt%==f goto install
if /i %prompt%==r goto configure
if /i %prompt%==q goto end
goto asklogin

:install
call :colors 17
title L2Web installer - Web database setup - Full install
echo Deleting web db tables for new content.
set cmdline="%mysqlPath%" -h %host% -u %user% --password=%pass% -D %db% ^< web_install.sql 2^> NUL
%cmdline%
if not %ERRORLEVEL% == 0 goto omfg
goto end

:end
call :colors 17
title L2Web installer - Script execution finished
cls
echo.
echo Thanks for using our software.
echo visit http://www.l2.pvpland.lv for more info about
echo the L2Web project.
echo.
pause
color
