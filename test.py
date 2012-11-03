import subprocess, os, sys
dirList=os.listdir(sys.argv[1])
filelist=""
for fname in dirList:
    filelist = filelist+" "+sys.argv[1]+"/"+fname
print '\nfileList: '+filelist+'\n'

code=(sys.argv[1]).split('/')
print './moss -l java'+filelist+' > ./res/res'+code[2];
tmp = os.system('perl ./moss -l'+sys.argv[2]+filelist+' > ./res/res'+code[2]+'.txt');
print '\nDone\n';

