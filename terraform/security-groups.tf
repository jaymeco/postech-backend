resource "aws_security_group" "sg-database" {
  name        = "security-group-database"
  description = "Security Group para a exposicao do banco de dados"
  vpc_id      = aws_vpc.database.id

  ingress {
    description = "HTTP"
    protocol    = "tcp"
    to_port     = var.DatabasePort
    from_port   = var.DatabasePort
    cidr_blocks = ["0.0.0.0/0"]
  }

  egress {
    description = "All"
    protocol    = "-1"
    to_port     = 0
    from_port   = 0
    cidr_blocks = ["0.0.0.0/0"]
  }
}

resource "aws_security_group" "eks_nodes_1" {
  name_prefix = "eks-nodes-1-"
  vpc_id      = aws_vpc.eks_vpc.id

  ingress {
    from_port   = 10250
    to_port     = 10250
    protocol    = "tcp"
    cidr_blocks = ["10.0.0.0/16"] # Substitua pelo CIDR do seu VPC
  }

  ingress {
    from_port   = 443
    to_port     = 443
    protocol    = "tcp"
    cidr_blocks = ["10.0.0.0/16"] # Substitua pelo CIDR do seu VPC
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }

  tags = {
    Name = "EKS Node Security Group 1"
  }
}

resource "aws_security_group" "eks_nodes_2" {
  name_prefix = "eks-nodes-2-"
  vpc_id      = aws_vpc.eks_vpc.id

  ingress {
    from_port   = 10250
    to_port     = 10250
    protocol    = "tcp"
    cidr_blocks = ["10.0.0.0/16"] # Substitua pelo CIDR do seu VPC
  }

  ingress {
    from_port   = 443
    to_port     = 443
    protocol    = "tcp"
    cidr_blocks = ["10.0.0.0/16"] # Substitua pelo CIDR do seu VPC
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }

  tags = {
    Name = "EKS Node Security Group 2"
  }
}