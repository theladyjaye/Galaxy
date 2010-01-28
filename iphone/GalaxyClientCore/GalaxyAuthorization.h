//
//  GalaxyAuthorization.h
//  GalaxyClientCore
//
//  Created by Adam Venturella on 1/25/10.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import <Foundation/Foundation.h>

enum
{
	GalaxyAuthorizationOAuth
	
}; 
typedef NSUInteger GalaxyAuthorizationType;

@interface GalaxyAuthorization : NSObject <NSCopying>{
	GalaxyAuthorizationType authorizationType;
	NSString * applicationKey;
	NSString * applicationSecret;
}
@property(nonatomic, assign) GalaxyAuthorizationType authorizationType;
@property(nonatomic, retain) NSString * applicationKey;
@property(nonatomic, retain) NSString * applicationSecret;
@end
