resource "kubernetes_service" "app_service" {
  depends_on = [aws_eks_node_group.eks_node_group]
  metadata {
    name = "postech-service"
  }

  spec {
    selector = {
      app = "postech-deployment"
    }

    port {
      port        = 80
      target_port = 80
    }

    type = "LoadBalancer"
  }
}
