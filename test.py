import subprocess, os, sys
dirList=os.listdir(sys.argv[1])
filelist=""
for fname in dirList:
    filelist = filelist+" "+sys.argv[1]+"/"+fname
print '\nfileList: '+filelist+'\n'
#print sys.argv[1]

code=(sys.argv[1]).split('/')
print './moss -l java'+filelist+' > ./res/res'+code[2];
tmp = os.system('perl ./moss -l'+sys.argv[2]+filelist+' > ./res/res'+code[2]+'.txt');
print '\nDone\n';


def runProcess(exe):    
    p = subprocess.Popen(exe, stdout=subprocess.PIPE, stderr=subprocess.STDOUT)
    while(True):
      retcode = p.poll() #returns None while subprocess is running
      line = p.stdout.readline()
      yield line
      if(retcode is not None):
        break

#for line in runProcess(['./moss', '-l', 'java', filelist]):
#    print line

