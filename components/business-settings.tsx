"use client"

import type React from "react"

import { useState } from "react"
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group"
import { useTranslation } from "@/lib/i18n"
import { Upload, Building2, MapPin, Phone, Globe, Mail, Lock } from "lucide-react"

interface BusinessSettingsProps {
  language: string
}

export default function BusinessSettings({ language }: BusinessSettingsProps) {
  const { t } = useTranslation(language)
  const [businessType, setBusinessType] = useState<string>("")
  const [logoPreview, setLogoPreview] = useState<string>("/company-logo-placeholder.png")
  const [isLoggedIn, setIsLoggedIn] = useState(false)
  const [companyInfo, setCompanyInfo] = useState({
    name: "Example Wine Company",
    urlLabel: "example-wine-co",
  })

  const handleLogoUpload = (event: React.ChangeEvent<HTMLInputElement>) => {
    const file = event.target.files?.[0]
    if (file) {
      const reader = new FileReader()
      reader.onload = (e) => {
        setLogoPreview(e.target?.result as string)
      }
      reader.readAsDataURL(file)
    }
  }

  const handleLogin = (e: React.FormEvent) => {
    e.preventDefault()
    setIsLoggedIn(true)
  }

  const handleLogout = () => {
    setIsLoggedIn(false)
  }

  return (
    <div className="max-w-4xl mx-auto space-y-6">
      <Card className="bg-white shadow-sm">
        <CardHeader>
          <CardTitle className="text-xl font-semibold text-gray-800">{t("qr_settings")}</CardTitle>
        </CardHeader>
        <CardContent className="space-y-6">
          {/* Login Section */}
          {!isLoggedIn ? (
            <div className="border-b pb-6">
              <h4 className="text-lg font-medium mb-4">{t("qr_login_litile")}</h4>
              <form onSubmit={handleLogin} className="space-y-4">
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <Label htmlFor="email">{t("qr_email")}:</Label>
                    <Input id="email" type="email" required className="mt-1" />
                  </div>
                  <div>
                    <Label htmlFor="password">{t("qr_password")}:</Label>
                    <Input id="password" type="password" required className="mt-1" />
                  </div>
                </div>
                <Button type="submit" className="bg-blue-600 hover:bg-blue-700">
                  <Lock className="w-4 h-4 mr-2" />
                  {t("qr_login")}
                </Button>
              </form>
            </div>
          ) : (
            <div className="border-b pb-6">
              <h4 className="text-lg font-medium mb-2">{t("qr_login_after")}</h4>
              <p className="text-lg mb-4">
                <span className="font-semibold">{t("qr_company_name")}: </span>
                <span className="text-green-600 font-bold">{companyInfo.name}</span>
              </p>
              <Button onClick={handleLogout} variant="outline">
                {t("qr_logout")}
              </Button>
            </div>
          )}

          {/* Business Settings Form */}
          <div className="space-y-6">
            {/* URL Alias */}
            <div>
              <h4 className="text-lg font-medium text-gray-600 mb-2">{t("qr_alise")}</h4>
              <div className="bg-gray-50 p-3 rounded-md">
                <p className="text-blue-600 font-mono">https://digi-card.co/{companyInfo.urlLabel}</p>
              </div>
            </div>

            {/* Business Type */}
            <div>
              <Label className="text-base font-medium">{t("qr_type_of_business")}:</Label>
              <RadioGroup value={businessType} onValueChange={setBusinessType} className="mt-2">
                <div className="flex items-center space-x-2">
                  <RadioGroupItem value="1" id="producer" />
                  <Label htmlFor="producer">{t("qr_producer")}</Label>
                </div>
                <div className="flex items-center space-x-2">
                  <RadioGroupItem value="2" id="printing" />
                  <Label htmlFor="printing">{t("qr_printing")}</Label>
                </div>
                <div className="flex items-center space-x-2">
                  <RadioGroupItem value="3" id="oenology" />
                  <Label htmlFor="oenology">{t("qr_oenology")}</Label>
                </div>
              </RadioGroup>
            </div>

            {/* Company Information */}
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div className="space-y-4">
                <div>
                  <Label htmlFor="companyName">
                    <Building2 className="w-4 h-4 inline mr-2" />
                    {t("qr_company_name")}:
                  </Label>
                  <Input id="companyName" required className="mt-1" />
                </div>

                <div>
                  <Label htmlFor="address">
                    <MapPin className="w-4 h-4 inline mr-2" />
                    {t("qr_address")}:
                  </Label>
                  <Input id="address" required className="mt-1" />
                </div>

                <div className="grid grid-cols-3 gap-2">
                  <div>
                    <Label htmlFor="city">{t("qr_city")}:</Label>
                    <Input id="city" required className="mt-1" />
                  </div>
                  <div>
                    <Label htmlFor="zip">{t("qr_zip")}:</Label>
                    <Input id="zip" required className="mt-1" />
                  </div>
                  <div>
                    <Label htmlFor="state">{t("qr_state")}:</Label>
                    <Input id="state" required className="mt-1" />
                  </div>
                </div>

                <div>
                  <Label htmlFor="telephone">
                    <Phone className="w-4 h-4 inline mr-2" />
                    {t("qr_tel")}:
                  </Label>
                  <Input id="telephone" type="tel" required className="mt-1" />
                </div>

                <div>
                  <Label htmlFor="website">
                    <Globe className="w-4 h-4 inline mr-2" />
                    {t("qr_site")}:
                  </Label>
                  <Input id="website" type="url" required className="mt-1" />
                </div>

                <div>
                  <Label htmlFor="email">
                    <Mail className="w-4 h-4 inline mr-2" />
                    {t("qr_email")}:
                  </Label>
                  <Input id="email" type="email" required className="mt-1" />
                </div>

                <div>
                  <Label htmlFor="password">
                    <Lock className="w-4 h-4 inline mr-2" />
                    {t("qr_password")}:
                  </Label>
                  <Input id="password" type="password" required className="mt-1" />
                </div>
              </div>

              {/* Logo Upload */}
              <div className="space-y-4">
                <div>
                  <Label className="text-base font-medium">Company Logo:</Label>
                  <div className="mt-2 border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                    <img
                      src={logoPreview || "/placeholder.svg"}
                      alt="Company Logo"
                      className="w-48 h-48 mx-auto object-cover rounded-lg mb-4"
                    />
                    <div className="space-y-2">
                      <Upload className="w-8 h-8 mx-auto text-gray-400" />
                      <div>
                        <label htmlFor="logo-upload" className="cursor-pointer">
                          <span className="text-blue-600 hover:text-blue-500 font-medium">Upload company logo</span>
                          <input
                            id="logo-upload"
                            type="file"
                            accept="image/*"
                            onChange={handleLogoUpload}
                            className="hidden"
                          />
                        </label>
                      </div>
                      <p className="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                    </div>
                  </div>
                </div>

                <div className="bg-yellow-50 border border-yellow-200 rounded-md p-3">
                  <p className="text-sm text-yellow-800">{t("qr_ssl_warning")}</p>
                </div>
              </div>
            </div>

            {/* Save Button */}
            <div className="flex justify-end pt-4 border-t">
              <Button className="bg-blue-600 hover:bg-blue-700 px-8">{t("qr_save")}</Button>
            </div>
          </div>
        </CardContent>
      </Card>
    </div>
  )
}
