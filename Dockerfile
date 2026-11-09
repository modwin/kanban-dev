FROM ubuntu:latest
LABEL authors="komvu"

ENTRYPOINT ["top", "-b"]