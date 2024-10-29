import random
import timeit
size=10
Left=size-size
Right=size-1
#A=[random.randint(1,500)for i in range(size)]
A=[9,15,73,76,80,84,90,92,95,99]
def quicksort(left,right):
	if (left<right):
		i=left
		j=right
		pivot=A[left]
		while(j>i):
			i=i+1
			while(A[i]<pivot):
				i=i+1
				if(i==size):
					break
			while(A[j]>pivot):
				j=j-1
				if(j==-1):
					break
			if (i<j):
				k=A[i]
				A[i]=A[j]
				A[j]=k
		l=A[j]
		A[j]=A[left]
		A[left]=l
		quicksort(left,j-1)
		quicksort(j+1,right)

print(A)

timer=timeit.timeit(lambda:quicksort(Left,Right),number=100)
print(A)
print(timer)