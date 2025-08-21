"use client"
import { Card, CardContent } from "@/components/ui/card"
import { Badge } from "@/components/ui/badge"
import { Check } from "lucide-react"
import Image from "next/image"

interface Certification {
  id: string
  name: string
  description: string
  image: string
  category: "italian" | "european"
}

const certifications: Certification[] = [
  {
    id: "doc",
    name: "D.O.C.",
    description: "Denominazione di Origine Controllata",
    image: "/images/certifications/doc.png",
    category: "italian",
  },
  {
    id: "docg",
    name: "D.O.C.G.",
    description: "Denominazione di Origine Controllata e Garantita",
    image: "/images/certifications/docg.png",
    category: "italian",
  },
  {
    id: "igt",
    name: "I.G.T.",
    description: "Indicazione Geografica Tipica",
    image: "/images/certifications/igt.png",
    category: "italian",
  },
  {
    id: "eu_dop",
    name: "EU DOP",
    description: "Denominazione d'Origine Protetta",
    image: "/images/certifications/eu_dop.png",
    category: "european",
  },
  {
    id: "eu_igp",
    name: "EU IGP",
    description: "Indicazione Geografica Protetta",
    image: "/images/certifications/eu_igp.png",
    category: "european",
  },
  {
    id: "eu_stg",
    name: "EU STG",
    description: "Specialità Tradizionale Garantita",
    image: "/images/certifications/eu_stg.png",
    category: "european",
  },
  {
    id: "eu_organic",
    name: "EU Organic",
    description: "European Union Organic Certification",
    image: "/images/certifications/eu_organic.png",
    category: "european",
  },
]

interface CertificationSelectorProps {
  selectedCertifications: string[]
  onCertificationChange: (certifications: string[]) => void
}

export function CertificationSelector({ selectedCertifications, onCertificationChange }: CertificationSelectorProps) {
  const toggleCertification = (certificationId: string) => {
    const updated = selectedCertifications.includes(certificationId)
      ? selectedCertifications.filter((id) => id !== certificationId)
      : [...selectedCertifications, certificationId]
    onCertificationChange(updated)
  }

  const italianCerts = certifications.filter((cert) => cert.category === "italian")
  const europeanCerts = certifications.filter((cert) => cert.category === "european")

  return (
    <div className="space-y-6">
      <div>
        <h3 className="text-lg font-semibold text-gray-900 mb-4">Italian Certifications</h3>
        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
          {italianCerts.map((cert) => (
            <Card
              key={cert.id}
              className={`cursor-pointer transition-all duration-200 hover:shadow-md ${
                selectedCertifications.includes(cert.id) ? "ring-2 ring-purple-500 bg-purple-50" : "hover:bg-gray-50"
              }`}
              onClick={() => toggleCertification(cert.id)}
            >
              <CardContent className="p-4 text-center">
                <div className="relative mb-3">
                  <Image
                    src={cert.image || "/placeholder.svg"}
                    alt={cert.name}
                    width={80}
                    height={80}
                    className="mx-auto"
                  />
                  {selectedCertifications.includes(cert.id) && (
                    <div className="absolute -top-2 -right-2 bg-purple-500 rounded-full p-1">
                      <Check className="h-4 w-4 text-white" />
                    </div>
                  )}
                </div>
                <h4 className="font-semibold text-gray-900 mb-1">{cert.name}</h4>
                <p className="text-sm text-gray-600">{cert.description}</p>
              </CardContent>
            </Card>
          ))}
        </div>
      </div>

      <div>
        <h3 className="text-lg font-semibold text-gray-900 mb-4">European Certifications</h3>
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          {europeanCerts.map((cert) => (
            <Card
              key={cert.id}
              className={`cursor-pointer transition-all duration-200 hover:shadow-md ${
                selectedCertifications.includes(cert.id) ? "ring-2 ring-purple-500 bg-purple-50" : "hover:bg-gray-50"
              }`}
              onClick={() => toggleCertification(cert.id)}
            >
              <CardContent className="p-4 text-center">
                <div className="relative mb-3">
                  <Image
                    src={cert.image || "/placeholder.svg"}
                    alt={cert.name}
                    width={60}
                    height={60}
                    className="mx-auto"
                  />
                  {selectedCertifications.includes(cert.id) && (
                    <div className="absolute -top-2 -right-2 bg-purple-500 rounded-full p-1">
                      <Check className="h-4 w-4 text-white" />
                    </div>
                  )}
                </div>
                <h4 className="font-semibold text-gray-900 mb-1">{cert.name}</h4>
                <p className="text-xs text-gray-600">{cert.description}</p>
              </CardContent>
            </Card>
          ))}
        </div>
      </div>

      {selectedCertifications.length > 0 && (
        <div className="mt-6">
          <h4 className="text-sm font-medium text-gray-900 mb-2">Selected Certifications:</h4>
          <div className="flex flex-wrap gap-2">
            {selectedCertifications.map((certId) => {
              const cert = certifications.find((c) => c.id === certId)
              return cert ? (
                <Badge key={certId} variant="secondary" className="bg-purple-100 text-purple-800">
                  {cert.name}
                </Badge>
              ) : null
            })}
          </div>
        </div>
      )}
    </div>
  )
}
