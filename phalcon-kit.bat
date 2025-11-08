@echo off
rem ==============================================
rem ==  Phalcon Kit windows command line tool   ==
rem ==============================================
@setlocal
set phalcon_kit_PATH=%~dp0
if "%PHP_COMMAND%" == "" set PHP_COMMAND=php.exe
"%PHP_COMMAND%" "%phalcon_kit_PATH%phalcon-kit" %*
@endlocal