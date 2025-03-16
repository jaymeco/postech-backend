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


# resource "aws_vpc_security_group_ingress_rule" "databaseIngress" {
#   security_group_id = aws_security_group.sg-database.id
#   description       = "HTTP"
#   ip_protocol       = "tcp"
#   to_port           = 5432
#   from_port         = 5432
# }

# resource "aws_vpc_security_group_egress_rule" "databaseEgress" {
#   security_group_id = aws_security_group.sg-database.id
#   description       = "All"
#   ip_protocol       = "-1"
#   to_port           = 0
#   from_port         = 0
# }
