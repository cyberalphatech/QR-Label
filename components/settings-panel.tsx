"use client"

import { useState } from "react"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Textarea } from "@/components/ui/textarea"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { Badge } from "@/components/ui/badge"
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs"
import { Save, Upload, User, Building, Globe, Shield, LogOut, CheckCircle, AlertCircle } from "lucide-react"

export function SettingsPanel() {
  const [profileData, setProfileData] = useState({
    name: "Vineyard Estate",
    email: "contact@vineyard-estate.com",
    phone: "+39 055 123 4567",
    address: "Via del Chianti 123",
    city: "Florence",
    zip: "50125",
    state: "Tuscany",
    website: "https://vineyard-estate.com",
    password: "",
  })

  const [loginStatus, setLoginStatus] = useState({
    isLoggedIn: true,
    loginEmail: "producer@vineyard-estate.com",
    accountType: "Producer",
  })

  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <div>
          <h2 className="text-3xl font-sans font-bold">Settings</h2>
          <p className="text-muted-foreground">Manage your account and application preferences</p>
        </div>
      </div>

      <Tabs defaultValue="profile" className="space-y-6">
        <TabsList className="grid w-full grid-cols-4">
          <TabsTrigger value="profile">Profile</TabsTrigger>
          <TabsTrigger value="account">Account</TabsTrigger>
          <TabsTrigger value="business">Business</TabsTrigger>
          <TabsTrigger value="system">System</TabsTrigger>
        </TabsList>

        <TabsContent value="profile" className="space-y-6">
          <Card>
            <CardHeader>
              <CardTitle className="flex items-center gap-2">
                <User className="w-5 h-5" />
                Profile Information
              </CardTitle>
              <CardDescription>Update your personal and contact information</CardDescription>
            </CardHeader>
            <CardContent className="space-y-4">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div className="space-y-2">
                  <Label htmlFor="name">Company/Producer Name</Label>
                  <Input
                    id="name"
                    value={profileData.name}
                    onChange={(e) => setProfileData({ ...profileData, name: e.target.value })}
                  />
                </div>
                <div className="space-y-2">
                  <Label htmlFor="email">Email Address</Label>
                  <Input
                    id="email"
                    type="email"
                    value={profileData.email}
                    onChange={(e) => setProfileData({ ...profileData, email: e.target.value })}
                  />
                </div>
              </div>

              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div className="space-y-2">
                  <Label htmlFor="phone">Phone Number</Label>
                  <Input
                    id="phone"
                    value={profileData.phone}
                    onChange={(e) => setProfileData({ ...profileData, phone: e.target.value })}
                  />
                </div>
                <div className="space-y-2">
                  <Label htmlFor="website">Website</Label>
                  <Input
                    id="website"
                    value={profileData.website}
                    onChange={(e) => setProfileData({ ...profileData, website: e.target.value })}
                  />
                </div>
              </div>

              <div className="space-y-2">
                <Label htmlFor="address">Address</Label>
                <Input
                  id="address"
                  value={profileData.address}
                  onChange={(e) => setProfileData({ ...profileData, address: e.target.value })}
                />
              </div>

              <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div className="space-y-2">
                  <Label htmlFor="city">City</Label>
                  <Input
                    id="city"
                    value={profileData.city}
                    onChange={(e) => setProfileData({ ...profileData, city: e.target.value })}
                  />
                </div>
                <div className="space-y-2">
                  <Label htmlFor="zip">ZIP Code</Label>
                  <Input
                    id="zip"
                    value={profileData.zip}
                    onChange={(e) => setProfileData({ ...profileData, zip: e.target.value })}
                  />
                </div>
                <div className="space-y-2">
                  <Label htmlFor="state">State/Region</Label>
                  <Input
                    id="state"
                    value={profileData.state}
                    onChange={(e) => setProfileData({ ...profileData, state: e.target.value })}
                  />
                </div>
              </div>

              <div className="flex justify-end">
                <Button className="bg-accent hover:bg-accent/90">
                  <Save className="w-4 h-4 mr-2" />
                  Save Profile
                </Button>
              </div>
            </CardContent>
          </Card>

          {/* Logo Upload */}
          <Card>
            <CardHeader>
              <CardTitle>Company Logo</CardTitle>
              <CardDescription>Upload your company logo for wine labels</CardDescription>
            </CardHeader>
            <CardContent>
              <div className="flex items-center gap-6">
                <div className="w-24 h-24 bg-muted rounded-lg flex items-center justify-center">
                  <Building className="w-8 h-8 text-muted-foreground" />
                </div>
                <div className="space-y-2">
                  <Button variant="outline">
                    <Upload className="w-4 h-4 mr-2" />
                    Upload Logo
                  </Button>
                  <p className="text-xs text-muted-foreground">PNG, JPG, SVG up to 5MB. Recommended: 400x400px</p>
                </div>
              </div>
            </CardContent>
          </Card>
        </TabsContent>

        <TabsContent value="account" className="space-y-6">
          {/* Login Status */}
          <Card>
            <CardHeader>
              <CardTitle className="flex items-center gap-2">
                <Shield className="w-5 h-5" />
                Account Status
              </CardTitle>
              <CardDescription>Current login and account information</CardDescription>
            </CardHeader>
            <CardContent>
              <div className="space-y-4">
                <div className="flex items-center justify-between p-4 border border-border rounded-lg">
                  <div className="flex items-center gap-3">
                    {loginStatus.isLoggedIn ? (
                      <CheckCircle className="w-5 h-5 text-green-500" />
                    ) : (
                      <AlertCircle className="w-5 h-5 text-yellow-500" />
                    )}
                    <div>
                      <p className="font-medium">{loginStatus.isLoggedIn ? "Logged In" : "Not Logged In"}</p>
                      <p className="text-sm text-muted-foreground">
                        {loginStatus.isLoggedIn ? loginStatus.loginEmail : "Please log in to access all features"}
                      </p>
                    </div>
                  </div>
                  <div className="flex items-center gap-2">
                    <Badge variant={loginStatus.isLoggedIn ? "default" : "secondary"}>{loginStatus.accountType}</Badge>
                    {loginStatus.isLoggedIn && (
                      <Button variant="outline" size="sm">
                        <LogOut className="w-4 h-4 mr-2" />
                        Logout
                      </Button>
                    )}
                  </div>
                </div>

                {!loginStatus.isLoggedIn && (
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div className="space-y-2">
                      <Label htmlFor="loginEmail">Email</Label>
                      <Input id="loginEmail" type="email" placeholder="Enter your email" />
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="loginPassword">Password</Label>
                      <Input id="loginPassword" type="password" placeholder="Enter your password" />
                    </div>
                    <div className="md:col-span-2">
                      <Button className="w-full bg-accent hover:bg-accent/90">Login to Account</Button>
                    </div>
                  </div>
                )}
              </div>
            </CardContent>
          </Card>

          {/* Password Change */}
          <Card>
            <CardHeader>
              <CardTitle>Change Password</CardTitle>
              <CardDescription>Update your account password</CardDescription>
            </CardHeader>
            <CardContent className="space-y-4">
              <div className="space-y-2">
                <Label htmlFor="currentPassword">Current Password</Label>
                <Input id="currentPassword" type="password" />
              </div>
              <div className="space-y-2">
                <Label htmlFor="newPassword">New Password</Label>
                <Input id="newPassword" type="password" />
              </div>
              <div className="space-y-2">
                <Label htmlFor="confirmPassword">Confirm New Password</Label>
                <Input id="confirmPassword" type="password" />
              </div>
              <Button variant="outline">Update Password</Button>
            </CardContent>
          </Card>
        </TabsContent>

        <TabsContent value="business" className="space-y-6">
          <Card>
            <CardHeader>
              <CardTitle className="flex items-center gap-2">
                <Building className="w-5 h-5" />
                Business Type
              </CardTitle>
              <CardDescription>Select your business category</CardDescription>
            </CardHeader>
            <CardContent className="space-y-4">
              <div className="space-y-2">
                <Label>Business Category</Label>
                <Select defaultValue="producer">
                  <SelectTrigger>
                    <SelectValue />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="producer">Wine Producer</SelectItem>
                    <SelectItem value="printing">Printing Company</SelectItem>
                    <SelectItem value="oenology">Oenology Consultant</SelectItem>
                    <SelectItem value="distributor">Distributor</SelectItem>
                  </SelectContent>
                </Select>
              </div>

              <div className="space-y-2">
                <Label htmlFor="businessDescription">Business Description</Label>
                <Textarea id="businessDescription" placeholder="Describe your business and specialties..." rows={4} />
              </div>

              <div className="space-y-2">
                <Label htmlFor="certifications">Certifications & Licenses</Label>
                <Textarea
                  id="certifications"
                  placeholder="List your business certifications, licenses, and accreditations..."
                  rows={3}
                />
              </div>
            </CardContent>
          </Card>

          <Card>
            <CardHeader>
              <CardTitle>QR Code Settings</CardTitle>
              <CardDescription>Configure QR code generation preferences</CardDescription>
            </CardHeader>
            <CardContent className="space-y-4">
              <div className="space-y-2">
                <Label htmlFor="qrBaseUrl">Base URL for QR Codes</Label>
                <Input id="qrBaseUrl" value="https://digi-card.net/" placeholder="https://your-domain.com/" />
              </div>

              <div className="space-y-2">
                <Label htmlFor="labelPrefix">Label URL Prefix</Label>
                <Input id="labelPrefix" placeholder="e.g., vineyard-estate" />
              </div>
            </CardContent>
          </Card>
        </TabsContent>

        <TabsContent value="system" className="space-y-6">
          <Card>
            <CardHeader>
              <CardTitle className="flex items-center gap-2">
                <Globe className="w-5 h-5" />
                System Information
              </CardTitle>
              <CardDescription>Application version and system details</CardDescription>
            </CardHeader>
            <CardContent>
              <div className="space-y-4">
                <div className="grid grid-cols-2 gap-4 text-sm">
                  <div>
                    <p className="font-medium">Application Version</p>
                    <p className="text-muted-foreground">v2.0.0</p>
                  </div>
                  <div>
                    <p className="font-medium">Module Version</p>
                    <p className="text-muted-foreground">QR Labels v1.0.0</p>
                  </div>
                  <div>
                    <p className="font-medium">Database Status</p>
                    <p className="text-green-600">Connected</p>
                  </div>
                  <div>
                    <p className="font-medium">Last Backup</p>
                    <p className="text-muted-foreground">2024-01-15 14:30</p>
                  </div>
                </div>
              </div>
            </CardContent>
          </Card>

          <Card>
            <CardHeader>
              <CardTitle>Data Management</CardTitle>
              <CardDescription>Export and backup your wine label data</CardDescription>
            </CardHeader>
            <CardContent className="space-y-4">
              <div className="flex flex-col sm:flex-row gap-4">
                <Button variant="outline" className="flex-1 bg-transparent">
                  Export Labels Data
                </Button>
                <Button variant="outline" className="flex-1 bg-transparent">
                  Backup Database
                </Button>
                <Button variant="outline" className="flex-1 bg-transparent">
                  Download QR Codes
                </Button>
              </div>
            </CardContent>
          </Card>
        </TabsContent>
      </Tabs>
    </div>
  )
}
