provider "kubernetes" {
  host                   = aws_eks_cluster.eks_cluster.endpoint
  cluster_ca_certificate = base64decode(aws_eks_cluster.eks_cluster.certificate_authority.0.data)
  token                  = data.aws_eks_cluster_auth.eks_auth.token
}

data "aws_eks_cluster_auth" "eks_auth" {
  name = aws_eks_cluster.eks_cluster.name
}

resource "aws_eks_cluster" "eks_cluster" {
  name     = "eks-postech"
  role_arn = var.LabRole
  vpc_config {
    security_group_ids = [ aws_security_group.eks_nodes_1.id, aws_security_group.eks_nodes_2.id ]
    subnet_ids = [
      aws_subnet.public_subnet_1.id,
      aws_subnet.public_subnet_2.id,
      aws_subnet.private_subnet_1.id,
      aws_subnet.private_subnet_2.id,
    ]
  }
}

# resource "aws_launch_template" "eks-template" {
#   name_prefix   = "eks-template-"
#   image_id      = "ami-001dd4635f9fa96b0"
#   instance_type = "t3.medium"

#   # ... outras configurações do launch template ...
# }

resource "aws_eks_node_group" "eks_node_group" {
  cluster_name    = aws_eks_cluster.eks_cluster.name
  node_group_name = "eks-postech-node-group"
  node_role_arn   = var.LabRole
  instance_types = [ "t3.medium" ]
  subnet_ids = [
    aws_subnet.private_subnet_1.id,
    aws_subnet.private_subnet_2.id,
  ]

#   launch_template {
#     id = aws_launch_template.eks-template.id
#     version = aws_launch_template.eks-template.latest_version
#   }

  scaling_config {
    desired_size = 2
    max_size     = 3
    min_size     = 1
  }

  depends_on = [
    aws_eks_cluster.eks_cluster,
  ]
}