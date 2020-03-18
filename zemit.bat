@echo off
rem ==============================================
rem ==     Zemit windows command line tool      ==
rem ==============================================
@setlocal
set zemit_PATH=%~dp0
if "%PHP_COMMAND%" == "" set PHP_COMMAND=php.exe
"%PHP_COMMAND%" "%zemit_PATH%zemit" %*
@endlocal